<x-slot name="header">
    <x-title-list icon="users">{{ __(key: 'Ordenes de trabajo') }}</x-title-list>
</x-slot>

<div class="max-w-12xl py-6 mx-auto sm:px-4 lg:px-6 space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-secondary-800 shadow sm:rounded-lg">
        <x-session-status/>
        <div class="flex flex-col">
            <div class="inline-block min-w-full">
                <x-primary-button type="button" wire:click="create()" class="mb-2">
                    <i class="fa-solid fa-plus me-1"></i>{{ __('Crear orden de trabajo') }}
                </x-primary-button>
                <div class="rounded overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                            <tr>
                                <x-table-th title="{{ __('Número de orden') }}" />
                                <x-table-th title="{{ __('Código interno') }}" />
                                <x-table-th title="{{ __('Cliente') }}" />
                                <x-table-th title="{{ __('Ciudad') }}" />
                                <x-table-th title="{{ __('Direción') }}" />
                                <x-table-th title="{{ __('Persona solicitante') }}" />
                                <x-table-th title="{{ __('Creardor de la orden') }}" />
                                <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($workOrders as $workOrder)
                            <tr
                                class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ $workOrder->order_number }}</x-table-td>
                                <x-table-td>{{ $workOrder->internal_code }}</x-table-td>
                                <x-table-td>{{ $workOrder->client->name }}</x-table-td>
                                <x-table-td>{{ $workOrder->city->name }}</x-table-td>
                                <x-table-td>{{ $workOrder->address }}</x-table-td>
                                <x-table-td>{{ $workOrder->personRequesting->first_name }} {{ $workOrder->personRequesting->last_name }}</x-table-td>
                                <x-table-td>{{ $workOrder->receiving_authorizing }}</x-table-td>
                                <x-table-td>
                                    <x-table-buttons id="{{ $workOrder->id }}" in_used=""/>
                                </x-table-td>
                            </tr>
                            @empty
                            <x-table-empty colspan="6" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $workOrders->links() }}
                </div>
            </div>
        </div>
        @if($showWorkOrder)
            @include('work_order.show')
        @endif
        @if($addWorkOrder)
            @include('work_order.create')
        @endif
        @if($updateWorkOrder)
            @include('work_order.edit')
        @endif
        @if($deleteWorkOrder)
            <x-table-modal-delete model="deleteWorkOrder" />
        @endif
    </div>
</div>
