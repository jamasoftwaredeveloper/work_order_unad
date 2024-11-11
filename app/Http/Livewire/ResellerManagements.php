<?php

namespace App\Http\Livewire;

use App\Http\Requests\ResellerManagementRequest;
use App\Models\Metadata;
use App\Models\RegisterOperation;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResellerManagements extends Component
{
    use WithPagination;
    public $password, $email, $observation, $status, $user_id, $status_value, $created_at, $passwordNewReseller, $confirmPasswordReseller;
    public $addResellerManagement = false, $updateResellerManagement = false, $deleteResellerManagement = false, $showResellerManagement = false, $modalRefreshPasswordResellerManagement = false, $modalConfirmDisabledResellerManagement = false, $changePasswordSeeResellerManagement = false;
    protected $listeners = ['render'];

    #[Title('Reseller managements')]
    public function rules()
    {
        return ResellerManagementRequest::rules($this->user_id);
    }

    public function render()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('title', ['Super Admin', 'Admin'])->where('status', 1);
        })->orderBy('id', 'asc')->paginate(15);
        return view('reseller_management.index', compact('users'));
    }
    public function resetFields()
    {
        $this->email = '';
        $this->password = '';
        $this->observation = '';
        $this->status_value = '';
        $this->user_id = '';
        $this->passwordNewReseller = '';
        $this->confirmPasswordReseller = '';
        $this->changePasswordSeeResellerManagement = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addResellerManagement = false;
        $this->updateResellerManagement = false;
        $this->deleteResellerManagement = false;
        $this->showResellerManagement  = false;
        $this->modalRefreshPasswordResellerManagement = false;
        $this->modalConfirmDisabledResellerManagement = false;
    }
    public function mount()
    {
        if (Gate::denies('reseller_management_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function create()
    {
        if (Gate::denies('reseller_management_add')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->user_id = '';
        $this->addResellerManagement = true;
        $this->status = Metadata::where('type', 'status')->get();

        return view('reseller_management.create');
    }

    public function store()
    {
        if (Gate::denies('reseller_management_add')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        try {
            $this->validate();
            DB::beginTransaction();
            $user = User::create([
                'email' => $this->email,
                'password' => $this->password,
                'status' => (int)$this->status_value,
                'observation' => $this->observation,
                'document_type_id' => 1,
                'phone_code_id' => 1,
                'city_id' => 1037
            ]);
            $user->save();
            $user->roles()->attach(3);
            RegisterOperation::create([
                'type' => 'create_reseller',
                'observation' => __("Reseller").' '. __("has been created"),
                'result' => 'successful',
                'status' => 'complete_process',
                'user_id' => Auth::user()->id
            ]);
            DB::commit();

            return redirect()->route('reseller_managements')
                ->with('message', trans('message.Created Successfully.', ['name' => __('City')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            RegisterOperation::create([
                'type' => 'create_reseller',
                'observation' => __("There was an error in the").' '. __("Create Reseller"),
                'result' => 'failed',
                'status' => 'failed_process',
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }
    public function show($id)
    {

        if (Gate::denies('reseller_management_index')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->email = $user->email;
        $this->observation = $user->observation;
        $this->status_value = $user->status;
        $this->showResellerManagement = true;
        $this->created_at = $user->created_at;

        return view('reseller_management.show');
    }

    public function edit($id)
    {

        if (Gate::denies('account_management_edit')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->status = Metadata::where('type', 'status')->get();
        $this->email = $user->email;
        $this->observation = $user->observation;
        $this->status_value = $user->status;
        $this->updateResellerManagement = true;
        $this->user_id = $user->id;
        return view('reseller_management.edit');
    }

    public function update()
    {
        if (Gate::denies('reseller_management_add')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        try {
            $this->validate([
                'observation' => 'required',
            ]);
            DB::beginTransaction();

            $user =  User::find($this->user_id);
            $user->observation = $this->observation;
            $user->save();
            RegisterOperation::create([
                'type' => 'create_reseller',
                'observation' => __('Reseller') .' '.__("cuenta actualizada con éxit"),
                'result' => 'successful',
                'status' => 'complete_process',
                'user_id' => Auth::user()->id
            ]);
            DB::commit();

            return redirect()->route('reseller_managements')
                ->with('message', trans('message.Created Successfully.', ['name' => __('City')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
          RegisterOperation::create([
                'type' => 'create_reseller',
                'observation' => __("There was an error in the").' '. __("Update Reseller"),
                'result' => 'failed',
                'status' => 'failed_process',
                'user_id' => Auth::user()->id
            ]);

            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }


    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function changePasswordReseller()
    {
        if (Gate::denies('reseller_management_edit')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        if ($this->passwordNewReseller != $this->confirmPasswordReseller) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.Password do not match.'))
                ->with('alert_class', 'danger');
        }

        $this->validate([
            'passwordNewReseller' => 'required|min:6',
            'confirmPasswordReseller' => 'required|min:6',
        ]);
        try {
            $user = User::find($this->user_id);
            if (!$user) {
                return redirect()->route('reseller_managements')
                    ->with('message', 'Account not found')
                    ->with('alert_class', 'danger');
            }

            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($this->passwordNewReseller),
            ]);
            DB::commit();
            $this->resetValidationAndFields();

            return redirect()->route('reseller_managements')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }

    public function changePasswordFormReseller($id)
    {

        if (Gate::denies('reseller_management_index')) {
            return redirect()->route('account_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->user_id = $user->id;
        $this->passwordNewReseller = '';
        $this->confirmPasswordReseller = '';
        $this->changePasswordSeeResellerManagement = true;

        return view('reseller_management.changePassword');
    }

    public function disabledEnable()
    {
        if (Gate::denies('reseller_management_edit')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        try {

            $user = User::find($this->user_id);

            if (!$user) {
                return redirect()->route('reseller_managements')
                    ->with('message', 'Account not found')
                    ->with('alert_class', 'danger');
            }
            DB::beginTransaction();
            $user->status =  $user->status === 1 ? 0 : 1;
            $user->save();
            DB::commit();
            $this->modalConfirmDisabledResellerManagement = false;
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('message', 'Error occurred: ' . $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }

    public function setModelConfirmId($id, $model)
    {
        if (Gate::denies('reseller_management_edit')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        if ($model === "disabledEnable") {
            $this->modalConfirmDisabledResellerManagement = true;
        }
        if ($model === "refreshPassword") {
            $this->modalRefreshPasswordResellerManagement = true;
        }
        $this->user_id = $user->id;
    }

    public function setDeleteId($id)
    {
        if (Gate::denies('reseller_management_delete')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->user_id = $user->id;
        $this->deleteResellerManagement = true;
    }


    public function delete()
    {
        if (Gate::denies('reseller_management_delete')) {
            return redirect()->route('reseller_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        try {

        $user = User::find($this->user_id);
        if (!$user) {
            return redirect()->route('reseller_managements')
                ->with('message', 'Account not found')
                ->with('alert_class', 'danger');
        }
        $user = User::find($this->user_id);
        if (!$user) {
            return redirect()->route('users')
                ->with('message', __('User not found'))
                ->with('alert_class', 'danger');
        }
        if (isset($user->image) && Storage::exists('public/images/' . $user->image->url)) {
            Storage::delete('public/images/' . $user->image->url);
        }

        DB::beginTransaction();
        $user->roles()->detach();
        $user->image()->delete();
        $user->delete();
        DB::commit();
          RegisterOperation::create([
                'type' => 'delete_reseller',
                'observation' => __("Reseller").' '. __("has been deleted"),
                'result' => 'failed',
                'status' => 'failed_process',
                'user_id' => Auth::user()->id
            ]);


        return redirect()->route('reseller_managements')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('Account management')]))
            ->with('alert_class', 'success');
        } catch (Exception $e) {
            RegisterOperation::create([
                'type' => 'delete_reseller',
                'observation' => __("There was an error in the").' '. __("By eliminating the reseller"),
                'result' => 'failed',
                'status' => 'failed_process',
                'user_id' => Auth::user()->id
            ]);
        }

    }
}
