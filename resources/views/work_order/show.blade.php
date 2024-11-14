<x-modal title="{{ __('Show Work Order') }}" wire:model="showWorkOrder" focusable>
    <div class="mt-6 space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 xs:grid-cols-2 gap-6">
            <div>
                <x-input-label for="order_number">{{ __('Número de orden') }} *</x-input-label>
                <p class="block mt-1 w-full">{{ $order_number }}</p>
            </div>
            <div>
                <x-input-label for="city_id" :value="__('Ciudad')" />
                <p class="block mt-1 w-full">{{ $city_id }}</p>
            </div>
            <div>
                <x-input-label for="client_id" :value="__('Cliente')" />
                <p class="block mt-1 w-full">{{$client_id}}</p>
            </div>
            <div>
                <x-input-label for="address">{{ __('Dirección') }} *</x-input-label>
                <p class="block mt-1 w-full">{{ $address }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Codigo interno')" />
                <p class="block mt-1 w-full">{{ $internal_code }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Marca')" />
                <p class="block mt-1 w-full">{{ $brand }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Modelo')" />
                <p class="block mt-1 w-full">{{ $model }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Magnitud')" />
                <p class="block mt-1 w-full">{{ $magnitude }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Serie')" />
                <p class="block mt-1 w-full">{{ $series }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Clase')" />
                <p class="block mt-1 w-full">{{ $class }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Resolución')" />
                <p class="block mt-1 w-full">{{ $resolution }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Alcance de medición')" />
                <p class="block mt-1 w-full">{{ $measuring_rangeity }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Tipo de solicitud')" />
                <p class="block mt-1 w-full">{{ $type_of_request }}</p>
            </div>
            <div>
                <x-input-label for="person_requesting_id" :value="__('⁠Persona que solicita')" />
                <p class="block mt-1 w-full">{{ $person_requesting_id  }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Medio de solicitud')" />
                <p class="block mt-1 w-full">{{ $means_of_application }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Fecha de solicitud')" />
                <p class="block mt-1 w-full">{{ $date_of_request }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Número de recepcion')" />
                <p class="block mt-1 w-full">{{ $reception_number }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Fecha de recepcion')" />
                <p class="block mt-1 w-full">{{ $date_of_reception }}</p>
            </div>
            <div>
                <x-input-label for="" :value="__('Nombre de quien recibe y autoriza')" />
                <p class="block mt-1 w-full">{{ $receiving_authorizing }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-1 xs:grid-cols-1 gap-1">
            <div>
                <x-input-label for="description_equipment">{{ __('⁠Descripción del equipo') }}</x-input-label>
                <p class="block mt-1 w-full">{{ $description_equipment }}</p>
            </div>
        </div>

        <h1 class="text-center mt-2"><b>{{ __('Actividades') }}</b></h1>

        <div class="grid grid-cols-1 md:grid-cols-1 xs:grid-cols-1 gap-1 mt-2">
            <div class="rounded overflow-x-auto">
                <table class="min-w-full text-left text-sm font-light">
                    <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                        <tr>
                            <x-table-th title="{{ __('Description activities') }}" />
                            <x-table-th title="{{ __('User responsible for activities') }}" />
                            <x-table-th title="{{ __('Date realization activities') }}" />
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rows as $key => $row)
                        <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                            <x-table-td>{{ $row['description_activities'] }}</x-table-td>
                            <x-table-td>{{ $row['user_responsible_activities'] }}</x-table-td>
                            <x-table-td>{{ $row['date_realization_activities'] }}</x-table-td>
                        </tr>
                        @empty
                        <x-table-empty colspan="4" />
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xs:grid-cols-2 gap-6 mt-4 flex justify-end">
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
</x-modal>
