<?php

namespace App\Http\Livewire;

use App\Http\Requests\CreditManagementRequest;
use App\Models\Metadata;
use App\Models\RegisterOperation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class CreditManagements extends Component
{
    protected $listeners = ['render'];
    public $updateCreditManagement = false, $user_id, $status_credit, $status, $monthly_points, $annual_points, $account, $observation;
    #[Title('Credit Management')]
    public function rules()
    {
        return CreditManagementRequest::rules();
    }
    public function render()
    {
        $credit_managements = User::whereDoesntHave('roles', function ($query) {
            $query->where('title', ['Super Admin', 'Admin'])->where('status', 1);
        })->orderBy('id', 'asc')->paginate(15);
        return view('credit_management.index', compact('credit_managements'));
    }

    public function resetFields()
    {
        $this->user_id = '';
        $this->status_credit = '';
        $this->monthly_points  = '';
        $this->annual_points  = '';
        $this->account  = '';
        $this->observation = '';
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->updateCreditManagement = false;
    }
    public function mount()
    {
        if (Gate::denies('credit_management_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }
    public function edit($id)
    {
        if (Gate::denies('credit_management_add')) {
            return redirect()->route('credit_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $user = User::find($id);
        $this->user_id = $user->id;
        $this->account = $user->email;
        $this->status =  Metadata::where('type', 'status_credit')->get();
        $this->updateCreditManagement = true;

        return view('credit_management.edit');
    }
    public function update()
    {
        if (Gate::denies('credit_management_edit')) {
            return redirect()->route('credit_managements')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        try {

            $this->validate([
                'status_credit' => 'required',
                'monthly_points' => 'nullable|numeric|required_without:annual_points',
                'annual_points' => 'nullable|numeric|required_without:monthly_points',
            ]);

            $user = User::find($this->user_id);

            if (!$user) {
                return redirect()->route('credit_managements')
                    ->with('message', 'Account not found')
                    ->with('alert_class', 'danger');
            }

            DB::beginTransaction();

            if ($this->status_credit === "recharge") {
                if ($this->monthly_points) {
                    $user->monthly_points_available = $user->monthly_points_available +  $this->monthly_points;
                    $user->monthly_accumulated_points = $user->monthly_accumulated_points +  $this->monthly_points;
                }
                if ($this->annual_points) {
                    $user->annual_points_available = $user->annual_points_available +  $this->annual_points;
                    $user->annual_accumulated_points = $user->annual_accumulated_points +  $this->annual_points;
                }
            } else {

                if ($this->monthly_points) {
                    $user->monthly_points_available = $user->monthly_points_available -  $this->monthly_points;
                    $user->monthly_accumulated_points = $user->monthly_accumulated_points -  $this->monthly_points;
                }
                if ($this->annual_points) {
                    $user->annual_points_available = $user->annual_points_available -  $this->annual_points;
                    $user->annual_accumulated_points = $user->annual_accumulated_points -  $this->annual_points;
                }
            }

            $user->save();
            RegisterOperation::create([
                'type' => 'create_credit',
                'observation' =>  __("The credit") ." ". __("has been created") .' '.__("And associated to the account") .' '. $user->email,
                'result' => 'successful',
                'status' => 'complete_process',
                'user_id' => Auth::user()->id
            ]);
            DB::commit();

            return redirect()->route('credit_managements')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('Account management')]))
                ->with('alert_class', 'success');
        } catch (\Exception $e) {
            DB::rollback();
            RegisterOperation::create([
                'type' => 'create_credit',
                'observation' =>__("There was an error in the").' '.__("Create Credit"),
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
}
