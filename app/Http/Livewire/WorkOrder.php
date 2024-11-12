<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Client;
use App\Models\User;
use App\Models\WorkOrder as ModelsWorkOrder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

class WorkOrder extends Component
{
    use WithPagination;

    public $countries, $country_id, $states, $state_id, $cities = null, $wark_order_id, $users = null;
    public $order_number, $client_id, $city_id, $address,  $internal_code, $description_equipment, $brand, $model, $magnitude, $series, $class, $clients = null;
    public $resolution, $measuring_rangeity, $type_of_request, $person_requesting_id, $means_of_application, $date_of_request, $reception_number, $date_of_reception;
    public $description_activities, $user_responsible_activities, $date_realization_activities;
    public $rows = [];
    public $addWorkOrder = false, $updateWorkOrder = false, $deleteWorkOrder = false;

    protected $listeners = ['render'];

    #[Title('Work Orders')]
    public function rules()
    {
        // return UserRequest::rules($this->user_id);
    }

    public function resetFields()
    {
        $this->clients = null;
        $this->cities = null;
        $this->users = null;
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
        $this->wark_order_id = "";
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
        return view('work_order.index', compact('workOrders'));
    }

    public function create()
    {
        if (Gate::denies('work_order_add')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->addWorkOrder     = true;
        $this->wark_order_id     = '';
        $this->cities   = City::orderBy('name', 'asc')->pluck('name', 'id');

        $this->clients   = Client::pluck('name', 'id');
        $this->order_number = Str::upper(Str::random(8));
        $this->users = User::pluck(DB::raw('CONCAT(first_name, " ", last_name)'), 'id');

        return view('work_order.create');
    }

    public function store()
    {
        if (Gate::denies('work_order_add')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->validate();

        return redirect()->route('work_orders')
            ->with('message', trans('message.Created Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success');
    }

    public function edit($id)
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        /* $user = User::find($id);

        if (!$user) {
            return redirect()->route('work_orders')
                ->with('message', __('User not found'))
                ->with('alert_class', 'danger');
        }
        $this->resetValidationAndFields();
        $this->user_id          = $user->id;
        $this->first_name       = $user->first_name;
        $this->updateWorkOrder       = true;
        return view('work_order.edit');
        */
    }

    public function update()
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $this->validate();

        return redirect()->route('work_orders')
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
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('work_orders')
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
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $user = User::find($this->user_id);
        if (!$user) {
            return redirect()->route('work_orders')
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

        return redirect()->route('work_orders')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success'); */
    }
    public function addRow()
    {
        $user = User::find($this->user_responsible_activities);
        // Asegurarse de que los campos no estén vacíos antes de agregar la fila
        if ($this->description_activities && $this->user_responsible_activities && $this->date_realization_activities) {
            $this->rows[] = [
                'description_activities' => $this->description_activities,
                'user_responsible_activities' =>  $user->full_name,
                'date_realization_activities' => $this->date_realization_activities,
            ];

            // Limpiar los campos de entrada después de agregar la fila
            $this->description_activities = '';
            $this->user_responsible_activities = '';
            $this->date_realization_activities = '';
        }
    }

    public function removeRow($index)
    {
        // Verifica si el índice existe en el array
        if (isset($this->rows[$index])) {
            unset($this->rows[$index]);
            // Reindexar el array para evitar problemas con índices desordenados
            $this->rows = array_values($this->rows);
        }
    }
}
