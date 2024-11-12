<x-modal title="{{ __('Create New Work Order') }}" wire:model="addWorkOrder" focusable :maxWidth="'xl'">
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors />
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>
        <div class="grid grid-cols-1 md:grid-cols-2 xs:grid-cols-2 gap-6">
            <div>
                <x-input-label for="order_number">{{ __('Order number') }} *</x-input-label>
                <x-text-input id="order_number" class="block mt-1 w-full" type="text"
                    name="order_number" :value="old('order_number')" wire:model="order_number"
                    autocomplete="off" maxlength="200" required autofocus />
                <x-input-error :messages="$errors->get('order_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="city_id" :value="__('Country')" />
                <x-select-input id="city_id" class="block mt-1 w-full"
                    name="city_id" wire:model="city_id">
                    <option value="">{{ __('Please select') }}</option>
                    @foreach ($cities as $key => $item)
                    <option value="{{$key}}" {{ old('city_id') == $key ? 'selected' : '' }}>{{$item}}</option>
                    @endforeach
                </x-select-input>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="client_id" :value="__('Client')" />
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
                <x-input-label for="address">{{ __('Address') }} *</x-input-label>
                <x-text-input id="address" class="block mt-1 w-full" type="text"
                    name="address" :value="old('address')" wire:model="address"
                    autocomplete="off" maxlength="200" required autofocus />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Internal code')" />
                <x-text-input id="internal_code" class="block mt-1 w-full" type="text"
                    name="internal_code" :value="old('internal_code')" wire:model="internal_code"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('internal_code')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="description_equipment">{{ __('Description equipment') }}</x-input-label>
                <x-text-area id="description_equipment" class="block mt-1 w-full" name="description_equipment" :value="$description_equipment" wire:model="description_equipment" rows="4" cols="50" autocomplete="off" maxlength="150" />
            </div>
            <div>
                <x-input-label for="" :value="__('Brand')" />
                <x-text-input id="brand" class="block mt-1 w-full" type="text"
                    name="brand" :value="old('brand')" wire:model="brand"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('brand')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Model')" />
                <x-text-input id="model" class="block mt-1 w-full" type="text"
                    name="model" :value="old('model')" wire:model="model"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('model')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Magnitude')" />
                <x-text-input id="magnitude" class="block mt-1 w-full" type="text"
                    name="magnitude" :value="old('model')" wire:model="magnitude"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('magnitude')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Series')" />
                <x-text-input id="series" class="block mt-1 w-full" type="text"
                    name="series" :value="old('series')" wire:model="series"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('series')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Class')" />
                <x-text-input id="class" class="block mt-1 w-full" type="text"
                    name="class" :value="old('class')" wire:model="class"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('class')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Resolution')" />
                <x-text-input id="resolution" class="block mt-1 w-full" type="text"
                    name="resolution" :value="old('resolution')" wire:model="resolution"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('resolution')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Measuring rangeity')" />
                <x-text-input id="measuring_rangeity" class="block mt-1 w-full" type="text"
                    name="measuring_rangeity" :value="old('measuring_rangeity')" wire:model="measuring_rangeity"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('measuring_rangeity')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Type of request')" />
                <x-text-input id="type_of_request" class="block mt-1 w-full" type="text"
                    name="type_of_request" :value="old('type_of_request')" wire:model="type_of_request"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('type_of_request')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="person_requesting_id" :value="__('Person requesting')" />
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
                <x-input-label for="" :value="__('Means of application')" />
                <x-text-input id="means_of_application" class="block mt-1 w-full" type="text"
                    name="means_of_application" :value="old('means_of_application')" wire:model="means_of_application"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('means_of_application')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Date oF request')" />
                <x-date-input id="date_of_request" class="block mt-1 w-full"
                    name="date_of_request" :value="old('date_of_request')" wire:model="date_of_request"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('date_of_request')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Reception number')" />
                <x-text-input id="reception_number" class="block mt-1 w-full" type="text"
                    name="reception_number" :value="old('reception_number')" wire:model="reception_number"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('reception_number')" class="mt-2" />
            </div>
            <div>
                <x-input-label for="" :value="__('Date of reception')" />
                <x-date-input id="date_of_reception" class="block mt-1 w-full"
                    name="date_of_reception" :value="old('date_of_reception')" wire:model="date_of_reception"
                    maxlength="4" autocomplete="off" />
                <x-input-error :messages="$errors->get('date_of_reception')" class="mt-2" />
            </div>
            <div class="flex justify-end gap-4">
                <x-primary-button type="button" wire:click.prevent="store()">
                    <i class="fa-solid fa-save me-1"></i>{{ __('Save') }}
                </x-primary-button>
                <x-secondary-button wire:click.prevent="cancel()">
                    <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
                </x-secondary-button>
            </div>
        </div>
    </form>

</x-modal>
