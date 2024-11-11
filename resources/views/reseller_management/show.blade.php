<x-modal title="{{ __('Show Account') }}" wire:model="showResellerManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <div>
            <div>
                <x-input-label for="email"><strong>{{ __('Email') }}</strong>: {{$email}}</x-input-label>
            </div>
            <div>
                <x-input-label for="status_value"><strong>{{ __('Status') }}</strong>: @if($status_value === 1)
                {{ __('Active') }}
                @else
                {{ __('Inactive') }}
                @endif
            </x-input-label>
        </div>
        <div>
            <x-input-label for="created_at"><strong>{{ __('Date created') }}</strong>: {{$created_at}}</x-input-label>
        </div>
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