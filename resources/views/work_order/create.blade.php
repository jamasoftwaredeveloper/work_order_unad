<x-modal title="{{ __('Crear orden de trabajo') }}" wire:model="addWorkOrder" focusable :maxWidth="xl">
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 xs:grid-cols-2 gap-6">
            <div>
                <x-input-label for="order_number">{{ __('Número de orden') }} *</x-input-label>
                <x-text-input id="order_number" class="block mt-1 w-full" type="text"
                    name="order_number" :value="old('order_number')" wire:model="order_number"
                    autocomplete="off" maxlength="200" required autofocus disabled />
                <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="city_id" :value="__('Ciudad')" />
                <x-select-input id="city_id" class="block mt-1 w-full  font-sans"
                    name="city_id" wire:model="city_id">
                    <option value="">{{ __('Please select') }}</option>
                    @foreach ($cities as $key => $item)
                    <option value="{{$key}}" {{ old('city_id') == $key ? 'selected' : '' }}>{{ $item }}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="client_id" :value="__('Cliente')" />
                <x-select-input id="client_id" class="block mt-1 w-full"
                    name="client_id" wire:model="client_id">
                    <option value="">{{ __('Please select') }}</option>
                    @foreach ($clients as $key => $item)
                    <option value="{{$key}}" {{ old('client_id') == $key ? 'selected' : '' }}>{{$item}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('client_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="address">{{ __('Dirección') }} *</x-input-label>
                <x-text-input id="address" class="block mt-1 w-full" type="text"
                    name="address" :value="old('address')" wire:model="address"
                    autocomplete="off" maxlength="200" required autofocus />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Codigo interno')" />
                <x-text-input id="internal_code" class="block mt-1 w-full" type="text"
                    name="internal_code" :value="old('internal_code')" wire:model="internal_code"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('internal_code')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Marca')" />
                <x-text-input id="brand" class="block mt-1 w-full" type="text"
                    name="brand" :value="old('brand')" wire:model="brand"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Modelo')" />
                <x-text-input id="model" class="block mt-1 w-full" type="text"
                    name="model" :value="old('model')" wire:model="model"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Magnitud')" />
                <x-text-input id="magnitude" class="block mt-1 w-full" type="text"
                    name="magnitude" :value="old('model')" wire:model="magnitude"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('magnitude')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Serie')" />
                <x-text-input id="series" class="block mt-1 w-full" type="text"
                    name="series" :value="old('series')" wire:model="series"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('series')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Clase')" />
                <x-text-input id="class" class="block mt-1 w-full" type="text"
                    name="class" :value="old('class')" wire:model="class"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('class')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Resolución')" />
                <x-text-input id="resolution" class="block mt-1 w-full" type="text"
                    name="resolution" :value="old('resolution')" wire:model="resolution"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('resolution')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Alcance de medición')" />
                <x-text-input id="measuring_rangeity" class="block mt-1 w-full" type="text"
                    name="measuring_rangeity" :value="old('measuring_rangeity')" wire:model="measuring_rangeity"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('measuring_rangeity')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Tipo de solicitud')" />

                <x-select-input id="type_of_request" class="block mt-1 w-full"
                    name="type_of_request" wire:model="type_of_request">
                    <option value="">{{ __('Please select') }}</option>
                    @foreach ($type_of_requests as $key => $item)
                    <option value="{{$key}}" {{ old('type_of_request') == $key ? 'selected' : '' }}>{{$item}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('type_of_request')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="person_requesting_id" :value="__('⁠Persona que solicita')" />
                <x-select-input id="person_requesting_id" class="block mt-1 w-full"
                    name="person_requesting_id" wire:model="person_requesting_id">
                    <option value="">{{ __('Please select') }}</option>
                    @foreach ($users as $key => $item)
                    <option value="{{$key}}" {{ old('person_requesting_id') == $key ? 'selected' : '' }}>{{$item}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('person_requesting_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Medio de solicitud')" />
                <x-text-input id="means_of_application" class="block mt-1 w-full" type="text"
                    name="means_of_application" :value="old('means_of_application')" wire:model="means_of_application"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('means_of_application')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Fecha de solicitud')" />
                <x-date-input id="date_of_request" class="block mt-1 w-full"
                    name="date_of_request" :value="old('date_of_request')" wire:model="date_of_request"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('date_of_request')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('⁠Número de recepcion')" />
                <x-text-input id="reception_number" class="block mt-1 w-full" type="text"
                    name="reception_number" :value="old('reception_number')" wire:model="reception_number"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('reception_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Fecha de recepcion')" />
                <x-date-input id="date_of_reception" class="block mt-1 w-full"
                    name="date_of_reception" :value="old('date_of_reception')" wire:model="date_of_reception"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('date_of_reception')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Nombre de quien recibe y autoriza')" />
                <x-text-input id="receiving_authorizing" class="block mt-1 w-full" type="text"
                    name="receiving_authorizing" :value="old('receiving_authorizing')" wire:model="receiving_authorizing"
                    autocomplete="off" />
                <x-input-error :messages="$errors->get('receiving_authorizing')" class="mt-2" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 xs:grid-cols-1 gap-1">
            <div>
                <x-input-label for="description_equipment">{{ __('⁠Descripción del equipo') }}</x-input-label>
                <x-text-area id="description_equipment" class="block mt-1 w-full" name="description_equipment" :value="$description_equipment" wire:model="description_equipment" rows="4" cols="50" autocomplete="off" maxlength="150" placeholder="Descripción de equipo"/>
            </div>
        </div>
    </form>

    <h1 class="text-center mt-2"><b> {{ __(key: 'Actividades') }}</b></h1>
    <form wire:submit.prevent="addRow" class="mt-2">
        <div class="grid grid-cols-1 md:grid-cols-1 xs:grid-cols-1 gap-1">
            <x-text-area id="description_activities" class="block mt-1 w-full" name="description_activities" :value="$description_activities" wire:model="description_activities" rows="4" cols="50" autocomplete="off" maxlength="150" placeholder="Descripción de actividades"/>
        </div>
        <div class="grid grid-cols-3 md:grid-cols-3 xs:grid-cols-1 gap-3">
            <x-select-input id="user_responsible_activities" class="block mt-1 w-full"
                name="user_responsible_activities" wire:model="user_responsible_activities" >
                <option value="">{{ __('Selecciona un usuario responsable de la actividad') }}</option>
                @foreach ($users as $key => $item)
                <option value="{{$key}}" {{ old('user_responsible_activities') == $key ? 'selected' : '' }}>{{$item}}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('user_responsible_activities')" class="mt-2" />
            <x-date-input id="date_realization_activities" class="block mt-1 w-full"
                name="date_realization_activities" :value="old('date_realization_activities')" wire:model="date_realization_activities"
                autocomplete="off" />
            <x-input-error :messages="$errors->get('date_realization_activities')" class="mt-2" />

            <button class="text-white bg-success-800 mt-2" type="submit"> <i class="fa-solid fa-plus me-1"></i> Agregar</button>
        </div>
    </form>
    <div class="grid grid-cols-1 md:grid-cols-1 xs:grid-cols-1 gap-1 mt-2">
        <div class="rounded overflow-x-auto">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                    <tr>
                        <x-table-th title="{{ __('Description activities') }}" />
                        <x-table-th title="{{ __('User responsible for activities') }}" />
                        <x-table-th title="{{ __('Date realization activities') }}" />
                        <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rows as $key => $row)
                    <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                        <x-table-td>{{ $row['description_activities'] }}</x-table-td>
                        <x-table-td>{{ $row['user_responsible_activities'] }}</x-table-td>
                        <x-table-td>{{ $row['date_realization_activities'] }}</x-table-td>
                        <x-table-td> <button wire:click="removeRow({{ $key }})"> <i class="fa-solid fa-trash text-red-500"></i></button></x-table-td>
                    </tr>
                    @empty
                    <x-table-empty colspan="4" />
                    @endforelse
                </tbody>
            </table>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 xs:grid-cols-2 gap-6 mt-4">
            <x-primary-button type="button" wire:click.prevent="store()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Save') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </div>
</x-modal>
