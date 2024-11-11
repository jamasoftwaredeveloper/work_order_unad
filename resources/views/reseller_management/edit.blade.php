<x-modal title="{{ __('Edit account reseller') }}" wire:model="addResellerManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <div>
            <x-input-label for="email">{{ __('Email') }}</x-input-label>
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email" :value="$email" wire:model="email" autocomplete="off" maxlength="150" :disabled="true" />
        </div>
        <div>
            <x-input-label for="observation">{{ __('Observation') }}</x-input-label>
            <x-text-area id="observation" class="block mt-1 w-full" name="observation" :value="$observation" wire:model="observation" rows="4" cols="50" autocomplete="off" maxlength="150" />
        </div>
        <div class="flex justify-end gap-4">
            <x-primary-button type="button" wire:click.prevent="update()">
                <i class="fa-solid fa-save me-1"></i>{{ __('Update') }}
            </x-primary-button>
            <x-secondary-button wire:click.prevent="cancel()">
                <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
            </x-secondary-button>
        </div>
    </form>
</x-modal>