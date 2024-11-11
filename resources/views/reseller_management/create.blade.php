<x-modal title="{{ __('Create new account reseller') }}" wire:model="addResellerManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors />
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>
        <div>
            <x-input-label for="email">{{ __('Email') }} *</x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="old('email')" wire:model="email" autocomplete="off" maxlength="150" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="status_value">{{ __('Status') }} *</x-input-label>
            <x-select-input id="status_value" class="block mt-1 w-full" name="status_value" wire:model="status_value" autocomplete="off" autofocus>
                <option >{{ __('Please select') }}</option>
                @foreach ($status as $item)
                <option value="{{$item->value}}">{{ __($item->label)}}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('status_value')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password">{{ __('Password') }} *</x-input-label>
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" :value="old('password')" wire:model="password" autocomplete="off" maxlength="150" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="flex justify-end gap-4">
            <x-primary-button type="button" wire:click.prevent="store()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Save') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>