<x-modal title="{{ __('Change password') }}" wire:model="changePasswordSeeResellerManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <x-validation-errors/>
        <p class="italic text-sm text-red-700 m-0">
            {{ __('Fields marked with * are required') }}
        </p>
        <div>
            <x-input-label for="password">{{ __('Password') }} *</x-input-label>
            <x-text-input id="passwordNewReseller" class="block mt-1 w-full" type="password" name="passwordNewReseller" wire:model="passwordNewReseller" :value="$passwordNewReseller" autocomplete="off" maxlength="150" />
            <x-input-error :messages="$errors->get('passwordNewReseller')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="confirmPasswordReseller">{{ __('Confirm Password') }} *</x-input-label>
            <x-text-input id="confirmPasswordReseller" class="block mt-1 w-full" type="password" name="confirmPasswordReseller" wire:model="confirmPasswordReseller" :value="$confirmPasswordReseller" autocomplete="off" maxlength="150" />
            <x-input-error :messages="$errors->get('confirmPasswordReseller')" class="mt-2" />
        </div>
        <div class="flex justify-end gap-4">
            <x-primary-button type="button" wire:click.prevent="changePasswordReseller()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Update') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>
