<?php

namespace App\Http\Livewire;

use App\Models\WorkOrder as ModelsWorkOrder;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Livewire\WithPagination;
use Livewire\Attributes\Title;

class WorkOrder extends Component
{
    use WithPagination;

    public $countries, $country_id, $states, $state_id, $cities;
    public $order_number, $client_id, $city_id, $address,  $internal_code, $description_equipment, $brand, $model, $magnitude, $series, $class;
    public $resolution, $measuring_rangeity, $type_of_request, $person_requesting_id, $means_of_application, $date_of_request, $reception_number, $date_of_reception;

    public $addWorkOrder = false, $updateWorkOrder = false, $deleteWorkOrder = false;

    protected $listeners = ['render'];

    #[Title('Work Orders')]
    public function rules()
    {
        // return UserRequest::rules($this->user_id);
    }

    public function resetFields()
    {

        $this->order_number = "";
        $this->client_id = "";
        $this->city_id = "";
        $this->address = "";
        $this->internal_code = "";
        $this->description_equipment = "";
        $this->brand = "";
        $this->model = "";
        $this->magnitude = "";
        $this->series = "";
        $this->class = "";
        $this->resolution = "";
        $this->measuring_rangeity = "";
        $this->type_of_request = "";
        $this->person_requesting_id = "";
        $this->means_of_application = "";
        $this->date_of_request = "";
        $this->reception_number = "";
        $this->date_of_reception = "";
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addWorkOrder = false;
        $this->updateWorkOrder = false;
        $this->deleteWorkOrder = false;
    }

    public function mount()
    {
        if (Gate::denies('work_order_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }

    public function render()
    {
        $workOrders = ModelsWorkOrder::orderBy('id', 'asc')->paginate(15);
        return view('work_order.index',compact('workOrders'));
    }

    public function create()
    {
        if (Gate::denies('work_order_add')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        /* $this->user_id     = '';
        $this->phone_codes = Country::orderBy('name', 'asc')->get();
        $this->countries   = $this->phone_codes;
        $this->documents   = DocumentType::orderBy('name', 'asc')->get();
        $this->addWorkOrder     = true;*/
        return view('user.create');
    }

    public function store()
    {
        if (Gate::denies('work_order_add')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->validate();

        return redirect()->route('users')
            ->with('message', trans('message.Created Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success');
    }

    public function edit($id)
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        /* $user = User::find($id);

        if (!$user) {
            return redirect()->route('users')
                ->with('message', __('User not found'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->user_id          = $user->id;
        $this->first_name       = $user->first_name;
        $this->updateWorkOrder       = true;
        return view('user.edit');
        */
    }

    public function update()
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate();

        return redirect()->route('users')
            ->with('message', trans('message.Updated Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success');
    }

    public function cancel()
    {
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {

        /*
        if (Gate::denies('work_order_delete')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('users')
                ->with('message', __('User not found'))
                ->with('alert_class', 'danger');
        }
        $this->user_id = $user->id;
        $this->resetValidationAndFields();
        $this->deleteWorkOrder = true; */
    }

    public function delete()
    {
        /*
        if (Gate::denies('work_order_delete')) {
            return redirect()->route('users')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
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

        return redirect()->route('users')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success'); */
    }
}
