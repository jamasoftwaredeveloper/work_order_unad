<?php

namespace App\Http\Livewire;

use App\Http\Requests\AccountManagementRequest;
use App\Models\AccountManagement;
use App\Models\City;
use App\Models\Country;
use App\Models\DocumentType;
use App\Rules\MacAddress;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use App\Models\Metadata;
use App\Models\RegisterOperation;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountManagements extends Component
{
    use WithPagination;

    public $credit_packages, $credit_package_value, $amount_of_allocated_credits, $number_of_accounts, $account_management_id = null, $account, $phone_codes, $countries, $documents, $states, $state_id, $cities, $city_id, $document_type_id, $document_number, $country_id, $address, $phone_code_id, $mac;
    public $buyer_name = '', $phone = '', $email = '', $observation = '';
    public $passwordNew, $confirmPassword;
    public $addAccountManagement = false, $updateAccountManagement = false, $deleteAccountManagement = false, $showAccountManagement = false, $changePasswordSee = false, $modalConfirmDisabled = false, $modalRefreshPassword = false;

    protected $listeners = ['render'];

    #[Title('Account managements')]
    public function rules()
    {
        return AccountManagementRequest::rules($this->account_management_id);
    }

    public function resetFields()
    {
        $this->credit_packages = '';
        $this->credit_package_value = '';
        $this->amount_of_allocated_credits = '';
        $this->number_of_accounts = '';
        $this->account_management_id = '';
        $this->buyer_name = '';
        $this->phone = '';
        $this->email = '';
        $this->observation = '';
        $this->account  = '';
        $this->document_type_id = '';
        $this->document_number = '';
        $this->country_id = '';
        $this->state_id = '';
        $this->city_id = '';
        $this->phone_code_id = '';
        $this->mac = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addAccountManagement = false;
        $this->updateAccountManagement = false;
        $this->deleteAccountManagement = false;
        $this->showAccountManagement = false;
        $this->changePasswordSee = false;
        $this->modalConfirmDisabled = false;
        $this->modalRefreshPassword = false;
    }
    public function mount()
    {
        if (Gate::denies('account_management_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $hasRole = User::find($user->id)->roles()->where('title', 'Super Admin')->exists();
        $account_managements = AccountManagement::orderBy('account', 'asc')->paginate(15);
        if (!$hasRole) {
            $account_managements = AccountManagement::where('user_id', $user->id)->orderBy('account', 'asc')->paginate(15);
        }
        return view('account_management.index', compact('account_managements'));
    }

    public function create()
    {
        if (Gate::denies('account_management_add')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->account_management_id = '';
        $this->addAccountManagement = true;
        $this->credit_packages = Metadata::where('type', 'credit_package')->get();
        return view('account_management.create');
    }

    public function store()
    {
        try {
            if (Gate::denies('account_management_add')) {
                return redirect()->route('account_managements')
                    ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                    ->with('alert_class', 'danger');
            }
            $user = User::find(Auth::user()->id);
            $hasRole = $user->roles()->where('title', 'Super Admin')->exists();

            if (!$hasRole) {
                $monthly_points_available = Auth::user()->monthly_points_available;
                $annual_points_available = Auth::user()->annual_points_available;

                if (($monthly_points_available === 0 || $this->number_of_accounts > $monthly_points_available) && $this->credit_package_value === "m") {
                    return redirect()->route('account_managements')
                        ->with('message', trans('message.The user has zero annual points or the number of accounts created exceeds the annual points allocated.'))
                        ->with('alert_class', 'danger');
                }

                if (($annual_points_available === 0 || $this->number_of_accounts > $annual_points_available) &&  $this->credit_package_value === "a") {
                    return redirect()->route('account_managements')
                        ->with('message', trans('message.The user has zero annual points or the number of accounts created exceeds the annual points allocated.'))
                        ->with('alert_class', 'danger');
                }
            }

            $this->validate();
            $day = $this->credit_package_value === "m" ? 30 : 360;
            $user_id = $user->id;
            DB::beginTransaction();
            for ($i = 0; $i < $this->number_of_accounts; $i++) {
                $accountManagement = AccountManagement::create([
                    'account' => substr(uniqid(), -5),
                    'password' => substr(uniqid(), -5),
                    'days_remaining_credits' => $day,
                    'user_id' => $user_id
                ]);
                $accountManagement->save();
            }
            if ($this->credit_package_value === "m") {
                $user->monthly_points_available  = $user->monthly_points_available - $this->number_of_accounts;
                $user->save();
            }
            if ($this->credit_package_value === "a") {
                $user->annual_points_available  = $user->annual_points_available - $this->number_of_accounts;
                $user->save();
            }

            RegisterOperation::create([
                'type' => 'create_account',
                'observation' => $this->number_of_accounts . " " . __("accounts successfully created"),
                'result' => 'successful',
                'status' => 'complete_process',
                'user_id' =>  $user_id
            ]);

            DB::commit();

            return redirect()->route('account_managements')
                ->with('message', trans('message.Created Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            RegisterOperation::create([
                'type' => 'create_account',
                'observation' => $this->number_of_accounts . " " . __("Accounts were not created"),
                'result' => 'failed',
                'status' => 'failed_process',
                'user_id' => Auth::user()->id
            ]);
            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }


    public function edit($id)
    {

        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $accountManagement = AccountManagement::find($id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->account  = $accountManagement->account;
        $this->buyer_name = $accountManagement->buyer_name;
        $this->phone = $accountManagement->phone;
        $this->email = $accountManagement->email;
        $this->observation = $accountManagement->observation;
        $this->updateAccountManagement = true;
        $this->phone_codes = Country::orderBy('name', 'asc')->get();
        $this->countries   = $this->phone_codes;
        $this->documents   = DocumentType::orderBy('name', 'asc')->get();
        $this->document_type_id = $accountManagement->document_type_id;
        $this->document_number  = $accountManagement->document_number;
        $this->city_id          = $accountManagement->city_id;
        $this->cities           = City::orderBy('name', 'asc')->get();
        $this->states           = State::orderBy('name', 'asc')->get();
        $this->address          = $accountManagement->address;
        $this->phone_code_id          = $accountManagement->phone_code_id;
        $this->mac = $accountManagement->mac;
        if (isset($accountManagement->city->state_id)) {
            $this->cities           = City::where('state_id', $accountManagement->city->state_id)->orderBy('name', 'asc')->get();
            $this->state_id         = $accountManagement->city->state_id;
        }
        if (isset($accountManagement->city->state->country_id)) {
            $this->states           = State::where('country_id', $accountManagement->city->state->country_id)->orderBy('name', 'asc')->get();
            $this->country_id       = $accountManagement->city->state->country_id;
        }

        $this->countries        = Country::orderBy('name', 'asc')->get();

        $this->account_management_id = $accountManagement->id;
        return view('account_management.edit');
    }

    public function countryChange($country_id)
    {
        if ($country_id != '') {
            $this->states = State::where('country_id', $country_id)->get();
        } else {
            $this->states = [];
            $this->state_id = '';
            $this->cities = [];
            $this->city_id = '';
        }
    }

    public function stateChange($state_id)
    {
        if ($state_id != '') {
            $this->cities = City::where('state_id', $state_id)->get();
        } else {
            $this->cities = [];
            $this->city_id = '';
        }
    }

    public function show($id)
    {

        if (Gate::denies('account_management_index')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $accountManagement = AccountManagement::find($id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->account  = $accountManagement->account;
        $this->buyer_name = $accountManagement->buyer_name;
        $this->phone = $accountManagement->phone;
        $this->email = $accountManagement->email;
        $this->observation = $accountManagement->observation;
        $this->showAccountManagement = true;
        $document_type = DocumentType::find($accountManagement->document_type_id);
        $this->document_type_id = $document_type->name;
        $this->document_number  = $accountManagement->document_number;
        $this->account_management_id = $accountManagement->id;
        $phone_code = Country::find($accountManagement->document_type_id);
        $this->phone_code_id          = $phone_code->phone_code;
        $this->mac = $accountManagement->mac;
        return view('account_management.show');
    }
    public function update()
    {
        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate(
            [
                'document_type_id' => ['required', 'integer', 'exists:document_types,id'],
                'document_number'  => ['required', 'string', 'max:50'],
                'country_id'          => ['required', 'integer'],
                'state_id'          => ['required', 'integer'],
                'city_id'          => ['required', 'integer'],
                'address'          => ['required', 'string', 'max:255'],
                'phone_code_id'    => ['required', 'integer', 'exists:countries,id'],
                'phone'            => ['required', 'string', 'max:50'],
                'email'            => ['required', 'string', 'email', 'max:255'],
                'buyer_name'            => ['required', 'string', 'max:255'],
                'mac' => ['required', new MacAddress],
            ]
        );

        $accountManagement = AccountManagement::find($this->account_management_id);

        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }

        DB::beginTransaction();
        $accountManagement->buyer_name = $this->buyer_name;
        $accountManagement->phone = $this->phone;
        $accountManagement->email = $this->email;
        $accountManagement->observation = $this->observation;
        $accountManagement->phone_code_id = $this->phone_code_id;
        $accountManagement->address = $this->address;
        $accountManagement->city_id = $this->city_id;
        $accountManagement->document_type_id = $this->document_type_id;
        $accountManagement->document_number = $this->document_number;
        $accountManagement->mac = $this->mac;
        $accountManagement->save();
        RegisterOperation::create([
            'type' => 'update_account',
            'observation' =>__("The account associated with this id") .' '.$accountManagement->account.' '.__("has been updated"),
            'result' => 'successful',
            'status' => 'complete_process',
            'user_id' =>  Auth::user()->id
        ]);
        DB::commit();

        return redirect()->route('account_managements')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
            ->with('alert_class', 'success');
    }

    public function refreshPassword()
    {
        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        try {

            $accountManagement = AccountManagement::find($this->account_management_id);

            if (!$accountManagement) {
                return redirect()->route('account_managements')
                    ->with('message', 'Account not found')
                    ->with('alert_class', 'danger');
            }

            DB::beginTransaction();
            $accountManagement->password = substr(uniqid(), -5);
            $accountManagement->save();
            DB::commit();

            return redirect()->route('account_managements')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }
    public function disabledEnable()
    {
        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        try {

            $accountManagement = AccountManagement::find($this->account_management_id);

            if (!$accountManagement) {
                return redirect()->route('account_managements')
                    ->with('message', 'Account not found')
                    ->with('alert_class', 'danger');
            }
            DB::beginTransaction();
            $accountManagement->in_used =  $accountManagement->in_used === 'disabled' ? 'not_used' : 'disabled';
            $accountManagement->save();
            DB::commit();
            $this->modalConfirmDisabled = false;
            return redirect()->route('account_managements')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }
    public function changePasswordForm($id)
    {

        if (Gate::denies('account_management_index')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $accountManagement = AccountManagement::find($id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->account_management_id = $accountManagement->id;
        $this->passwordNew = '';
        $this->confirmPassword = '';
        $this->changePasswordSee = true;
        return view('account_management.changePassword');
    }
    public function changePassword()
    {
        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        if ($this->passwordNew != $this->confirmPassword) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.Password do not match.'))
                ->with('alert_class', 'danger');
        }

        $this->validate([
            'passwordNew' => 'required|min:6',
            'confirmPassword' => 'required|min:6',
        ]);
        $accountManagement = AccountManagement::find($this->account_management_id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        DB::beginTransaction();
        $accountManagement->password  = $this->passwordNew;
        $accountManagement->save();
        DB::commit();
        return redirect()->route('account_managements')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
            ->with('alert_class', 'success');
    }

    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {
        if (Gate::denies('account_management_delete')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $accountManagement = AccountManagement::find($id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->account_management_id = $accountManagement->id;
        $this->deleteAccountManagement = true;
    }


    public function setModelConfirmId($id, $model)
    {
        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $accountManagement = AccountManagement::find($id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        if ($model === "disabledEnable") {
            $this->modalConfirmDisabled = true;
        }
        if ($model === "refreshPassword") {
            $this->modalRefreshPassword = true;
        }
        $this->account_management_id = $accountManagement->id;
    }

    public function delete()
    {
        if (Gate::denies('account_management_delete')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $accountManagement = AccountManagement::find($this->account_management_id);
        if (!$accountManagement) {
            return redirect()->route('account_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }

        RegisterOperation::create([
            'type' => 'delete_account',
            'observation' =>__("The account associated with this id") .' '. $accountManagement->account.' '.__("has been eliminated"),
            'result' => 'successful',
            'status' => 'complete_process',
            'user_id' =>  Auth::user()->id
        ]);
        DB::beginTransaction();
        $accountManagement->delete();
        DB::commit();

        return redirect()->route('account_managements')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('Account management')]))
            ->with('alert_class', 'success');
    }
}
