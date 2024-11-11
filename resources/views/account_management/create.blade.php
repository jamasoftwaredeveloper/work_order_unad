<x-modal title="{{ __('Create new account') }}" wire:model="addAccountManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors/>
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>
        <div>
            <x-input-label for="credit_packages_value">{{ __('Credit package') }} *</x-input-label>
            <x-select-input id="credit_packages_value" class="block mt-1 w-full" 
                name="credit_package_value" wire:model="credit_package_value" autocomplete="off" autofocus>
                <option value="">{{ __('Please select') }}</option>
                @foreach ($credit_packages as $item)
                    <option value="{{$item->value}}" >{{ __($item->label)}}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('credit_package_value')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="amount_of_allocated_credits">{{ __('The amount of credits allocated per account') }} *</x-input-label>
            <x-text-input id="amount_of_allocated_credits" class="block mt-1 w-full" type="number"
                name="amount_of_allocated_credits" :value="old('amount_of_allocated_credits')" wire:model="amount_of_allocated_credits"
                autocomplete="off" maxlength="150" required />
            <x-input-error :messages="$errors->get('amount_of_allocated_credits')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="number_of_accounts">{{ __('Number of accounts requested for creation') }} *</x-input-label>
            <x-text-input id="number_of_accounts" class="block mt-1 w-full" type="text"
                name="number_of_accounts" :value="old('number_of_accounts')" wire:model="number_of_accounts"
                autocomplete="off" maxlength="150" required />
            <x-input-error :messages="$errors->get('number_of_accounts')" class="mt-2" />
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