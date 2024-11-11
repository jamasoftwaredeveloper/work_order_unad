<x-modal title="{{ __('Recharge or deduction of credits') }}" wire:model="updateCreditManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-input-label for="account">{{ __('Account') }}</x-input-label>
        <x-text-input id="account" class="block mt-1 w-full" type="text" name="account" :value="$account" wire:model="account" autocomplete="off" maxlength="150" :disabled="true" />
        <x-input-label for="status_credit">{{ __('Type of credit') }} *</x-input-label>
        <x-select-input id="status_credit" class="block mt-1 w-full" name="status_credit" wire:model="status_credit" autocomplete="off" autofocus>
            <option value="">{{ __('Please select') }}</option>
            @foreach ($status as $item)
            <option value="{{$item->value}}">{{ __($item->label)}}</option>
            @endforeach
        </x-select-input>
        <x-input-error :messages="$errors->get('status_credit')" class="mt-2" />
        <div>
            <x-input-label for="monthly_points">{{ __('Monthly points') }} *</x-input-label>
            <x-text-input id="monthly_points" class="block mt-1 w-full" type="number" name="monthly_points" :value="old('monthly_points')" wire:model="monthly_points" autocomplete="off" maxlength="150" required autofocus />
            <x-input-error :messages="$errors->get('monthly_points')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="monthly_points">{{ __('Annual points') }} *</x-input-label>
            <x-text-input id="annual_points" class="block mt-1 w-full" type="number" name="annual_points" :value="old('annual_points')" wire:model="annual_points" maxlength="5" autocomplete="off" />
            <x-input-error :messages="$errors->get('annual_points')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="observation">{{ __('Observation') }}</x-input-label>
            <x-text-area id="observation" class="block mt-1 w-full" name="observation" :value="$observation" wire:model="observation" rows="4" cols="50" autocomplete="off" maxlength="150" />
        </div>
        <div class="flex justify-end gap-4">
            <x-primary-button type="button" wire:click.prevent="update()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Save') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>