<x-modal title="{{ __('Show Credit Management') }}" wire:model="showCreditManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <div>
            <div>
                <x-input-label for="observation"><strong>{{ __('Observation') }}</strong>: {{$observation}}</x-input-label>
            </div>
            <div class="flex justify-end gap-4">
                <x-secondary-button wire:click.prevent="cancel()">
                    <i class="fa-solid fa-ban me-1"></i><strong>{{ __('Cancel') }}</strong>
                </x-secondary-button>
            </div>
    </form>
</x-modal>