<?php

namespace App\Http\Livewire;

use App\Http\Requests\WorkOrderRequest;
use App\Models\Activity;
use App\Models\City;
use App\Models\Client;
use App\Models\User;
use App\Models\WorkOrder as ModelsWorkOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Illuminate\Support\Str;

class WorkOrder extends Component
{
    use WithPagination;

    public $cities = null, $users = null, $clients = null;

    public $wark_order_id = null,
        $order_number = null,
        $client_id = null,
        $city_id = null,
        $address = null,
        $internal_code = null,
        $description_equipment = null,
        $brand = null,
        $model = null,
        $magnitude = null,
        $series = null,
        $class = null,
        $resolution = null,
        $measuring_rangeity = null,
        $type_of_request = null,
        $person_requesting_id = null,
        $means_of_application = null,
        $date_of_request = null,
        $reception_number = null,
        $date_of_reception = null,
        $receiving_authorizing = null;

    public $description_activities = null, $user_responsible_activities = null, $date_realization_activities = null;
    public $rows = [];
    public $type_of_requests = [];
    public $addWorkOrder = false, $updateWorkOrder = false, $deleteWorkOrder = false, $showWorkOrder = false, $auth = null, $date_current = null;

    protected $listeners = ['render'];

    #[Title('Work Orders')]
    public function rules()
    {
        return WorkOrderRequest::rules($this->wark_order_id);
    }

    public function resetFields()
    {
        $this->wark_order_id = null;
        $this->order_number = null;
        $this->client_id = null;
        $this->city_id = null;
        $this->address = null;
        $this->internal_code = null;
        $this->description_equipment = null;
        $this->brand = null;
        $this->model = null;
        $this->magnitude = null;
        $this->series = null;
        $this->class = null;
        $this->resolution = null;
        $this->measuring_rangeity = null;
        $this->type_of_request = null;
        $this->person_requesting_id = null;
        $this->means_of_application = null;
        $this->date_of_request = null;
        $this->reception_number = null;
        $this->date_of_reception = null;
        $this->receiving_authorizing = null;

        $this->description_activities = null;
        $this->user_responsible_activities = null;
        $this->date_realization_activities = null;
    }

    public function resetValidationAndFields()
    {
        $this->resetValidation();
        $this->resetFields();
        $this->addWorkOrder = false;
        $this->updateWorkOrder = false;
        $this->deleteWorkOrder = false;
        $this->type_of_requests  = [

            'preventive' => __('Preventivo'),
            'corrective' => __('Corrrectivo')

        ];
    }

    public function mount()
    {
        if (Gate::denies('work_order_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        $this->auth = Auth::id();
        $this->date_current = now();
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
        $this->wark_order_id     = null;
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

        DB::beginTransaction();

        try {
            // Realiza las operaciones de base de datos
            $this->validate();
            $workOrder = ModelsWorkOrder::create([
                'order_number' => $this->order_number,
                'client_id' => $this->client_id,
                'city_id' => $this->city_id,
                'address' => $this->address,
                'internal_code' => $this->internal_code,
                'description_equipment' => $this->description_equipment,
                'brand' => $this->brand,
                'model' => $this->model,
                'magnitude' => $this->magnitude,
                'series' => $this->series,
                'class' => $this->class,
                'resolution' => $this->resolution,
                'measuring_rangeity' => $this->measuring_rangeity,
                'type_of_request' => $this->type_of_request,
                'person_requesting_id' => $this->person_requesting_id,
                'means_of_application' => $this->means_of_application,
                'date_of_request' => $this->date_of_request,
                'reception_number' => $this->reception_number,
                'date_of_reception' => $this->date_of_reception,
                'receiving_authorizing' => $this->receiving_authorizing,
                'user_creator_id' => $this->auth
            ]);
            $this->wark_order_id = $workOrder->id;
            $data = array_map(function ($row,) {
                return [
                    'work_order_id' => $this->wark_order_id,
                    'description_activities' => $row['description_activities'],
                    'user_responsible_activities' => $row['user_responsible_activities'],
                    'date_realization_activities' => $row['date_realization_activities'],
                    'created_at' => $this->date_current,
                    'updated_at' => $this->date_current
                ];
            }, $this->rows);

            // Insertar todas las actividades a través de la relación
            $workOrder->actividades()->insert($data);

            DB::commit();
            return redirect()->route('work_orders')
                ->with('message', trans('message.Created Successfully.', ['name' => __('Order')]))
                ->with('alert_class', 'success');

            // Si todo está bien, confirma la transacción
        } catch (\Exception $e) {
            // Si ocurre algún error, deshace la transacción
            DB::rollBack();
            return redirect()->route('work_orders')
                ->with('message', $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }

    public function edit($id)
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $workOrder = ModelsWorkOrder::find($id);

        if (!$workOrder) {
            return redirect()->route('work_orders')
                ->with('message', __('Ordén e trabajo no encontrada'))
                ->with('alert_class', 'danger');
        }

        $this->resetValidationAndFields();
        $this->cities   = City::orderBy('name', 'asc')->pluck('name', 'id');
        $this->clients   = Client::pluck('name', 'id');
        $this->users = User::pluck(DB::raw('CONCAT(first_name, " ", last_name)'), 'id');
        $this->model =  $workOrder->model;
        $this->order_number =  $workOrder->order_number;
        $this->wark_order_id = $workOrder->id;
        $this->order_number = $workOrder->order_number;
        $this->client_id = $workOrder->client_id;
        $this->city_id = $workOrder->city_id;
        $this->address = $workOrder->address;
        $this->internal_code = $workOrder->internal_code;
        $this->description_equipment = $workOrder->description_equipment;
        $this->brand = $workOrder->brand;
        $this->brand = $workOrder->brand;
        $this->magnitude = $workOrder->magnitude;
        $this->series = $workOrder->series;
        $this->class = $workOrder->class;
        $this->resolution = $workOrder->resolution;
        $this->measuring_rangeity = $workOrder->measuring_rangeity;
        $this->type_of_request = $workOrder->type_of_request;
        $this->person_requesting_id = $workOrder->person_requesting_id;
        $this->means_of_application = $workOrder->means_of_application;
        $this->date_of_request = $workOrder->date_of_request;
        $this->reception_number = $workOrder->reception_number;
        $this->date_of_reception = $workOrder->date_of_reception;
        $this->receiving_authorizing = $workOrder->receiving_authorizing;
        $this->updateWorkOrder       = true;

        $this->rows = $workOrder->actividades;

        return view('work_order.edit');
    }
    public function show($id)
    {
        /*
        if (Gate::denies('work_order_show')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }*/

        $workOrder = ModelsWorkOrder::find($id);

        if (!$workOrder) {
            return redirect()->route('work_orders')
                ->with('message', __('Ordén e trabajo no encontrada'))
                ->with('alert_class', 'danger');
        }
        $this->rows = $workOrder->actividades;
        $this->order_number =  $workOrder->order_number;
        $this->model =  $workOrder->model;
        $this->wark_order_id = $workOrder->id;
        $this->client_id = $workOrder->client->name;
        $this->city_id = $workOrder->city->name;
        $this->address = $workOrder->address;
        $this->internal_code = $workOrder->internal_code;
        $this->description_equipment = $workOrder->description_equipment;
        $this->brand = $workOrder->brand;
        $this->brand = $workOrder->brand;
        $this->magnitude = $workOrder->magnitude;
        $this->series = $workOrder->series;
        $this->class = $workOrder->class;
        $this->resolution = $workOrder->resolution;
        $this->measuring_rangeity = $workOrder->measuring_rangeity;
        $this->type_of_request = $workOrder->type_of_request  == 'preventive' ? 'Preventivo' : 'Correctivo';
        $this->person_requesting_id = $workOrder->personRequesting->first_name . ' ' . $workOrder->personRequesting->last_name;
        $this->means_of_application = $workOrder->means_of_application;
        $this->date_of_request = $workOrder->date_of_request;
        $this->reception_number = $workOrder->reception_number;
        $this->date_of_reception = $workOrder->date_of_reception;
        $this->receiving_authorizing = $workOrder->receiving_authorizing;
        $this->showWorkOrder = true;
        return view('work_order.show');
    }

    public function update()
    {
        if (Gate::denies('work_order_edit')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
        DB::beginTransaction();

        try {
            // Realiza las operaciones de base de datos
            $this->validate();
            $workOrder = ModelsWorkOrder::find($this->wark_order_id);
            if (!$workOrder) {
                return redirect()->route('work_orders')
                    ->with('message', __('Ordén e trabajo no encontrada'))
                    ->with('alert_class', 'danger');
            }

            $workOrder->actividades()->delete();

            $workOrder->update([
                'order_number' => $this->order_number,
                'client_id' => $this->client_id,
                'city_id' => $this->city_id,
                'address' => $this->address,
                'internal_code' => $this->internal_code,
                'description_equipment' => $this->description_equipment,
                'brand' => $this->brand,
                'model' => $this->model,
                'magnitude' => $this->magnitude,
                'series' => $this->series,
                'class' => $this->class,
                'resolution' => $this->resolution,
                'measuring_rangeity' => $this->measuring_rangeity,
                'type_of_request' => $this->type_of_request,
                'person_requesting_id' => $this->person_requesting_id,
                'means_of_application' => $this->means_of_application,
                'date_of_request' => $this->date_of_request,
                'reception_number' => $this->reception_number,
                'date_of_reception' => $this->date_of_reception,
                'receiving_authorizing' => $this->receiving_authorizing,
                'user_creator_id' => $this->auth // Asegúrate de que esto sea el ID del usuario autenticado
            ]);

            $data = array_map(function ($row,) {
                return [
                    'work_order_id' => $this->wark_order_id,
                    'description_activities' => $row['description_activities'],
                    'user_responsible_activities' => $row['user_responsible_activities'],
                    'date_realization_activities' => $row['date_realization_activities'],
                    'created_at' => $this->date_current,
                    'updated_at' => $this->date_current
                ];
            }, $this->rows);

            // Insertar todas las actividades a través de la relación
            $workOrder->actividades()->insert($data);

            // Si todo está bien, confirma la transacción
            DB::commit();
            return redirect()->route('work_orders')
                ->with('message', trans('message.Updated Successfully.', ['name' => __('User')]))
                ->with('alert_class', 'success');

        } catch (\Exception $e) {
            // Si ocurre algún error, deshace la transacción
            DB::rollBack();
            // Opcional: puedes manejar el error aquí o lanzarlo
            return redirect()->route('work_orders')
                ->with('message', $e->getMessage())
                ->with('alert_class', 'danger');
        }
    }

    public function cancel()
    {
        $this->showWorkOrder =false;
        $this->resetValidationAndFields();
    }

    public function setDeleteId($id)
    {

        if (Gate::denies('work_order_delete')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $wordOrder = ModelsWorkOrder::find($id);
        if (!$wordOrder) {
            return redirect()->route('work_orders')
                ->with('message', __('Orden de trabajo, no encontrada'))
                ->with('alert_class', 'danger');
        }
        $this->wark_order_id = $wordOrder->id;
        $this->resetValidationAndFields();
        $this->deleteWorkOrder = true;
    }

    public function delete()
    {

        if (Gate::denies('work_order_delete')) {
            return redirect()->route('work_orders')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }

        $wordOrder = ModelsWorkOrder::find($this->wark_order_id);
        if (!$wordOrder) {
            return redirect()->route('work_orders')
                ->with('message', __('Orden de trabajo, no encontrada'))
                ->with('alert_class', 'danger');
        }

        DB::beginTransaction();
        $wordOrder->actividades()->detach();
        $wordOrder->delete();
        DB::commit();

        return redirect()->route('work_orders')
            ->with('message', trans('message.Deleted Successfully.', ['name' => __('User')]))
            ->with('alert_class', 'success');
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
