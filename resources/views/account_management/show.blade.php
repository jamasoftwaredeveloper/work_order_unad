<x-modal title="{{ __('Show Account') }}" wire:model="updateAccountManagement" focusable>
    <form class="mt-6 space-y-6" method="POST">
        @csrf
        <div>
            <x-input-label for="account"><strong>{{ __('Account') }}</strong> : {{$account}}</x-input-label>
            <div>
                <x-input-label for="mac"><strong>{{ __('Mac') }}</strong>: {{$mac}}</x-input-label>
            </div>
            <div>
                <x-input-label for="buyer_name"><strong>{{ __('Buyer name') }}</strong>: {{$buyer_name}}</x-input-label>
            </div>
            <div>
                <x-input-label for="email"><strong>{{ __('Email') }}</strong>: {{$email}}</x-input-label>
            </div>
            <div>
                <x-input-label for="phone_code"><strong>{{ __('Phone code') }}</strong>: +{{$phone_code_id}}</x-input-label>
            </div>
            <div>
                <x-input-label for="phone"><strong>{{ __('Phone') }}</strong>: {{$phone}}</x-input-label>
            </div>
            <div>
                <x-input-label for="observation"><strong>{{ __('Observation') }}</strong>: {{$observation}}</x-input-label>
            </div>
            <div>
                <x-input-label for="document"><strong>{{ __('Document Type') }}</strong>: {{  $document_type_id}}</x-input-label>
            </div>
            <div>
                <x-input-label for="document"><strong>{{ __('Document number') }}</strong> :{{ $document_number}}</x-input-label>
            </div>

            <div class="flex justify-end gap-4">
                <x-secondary-button wire:click.prevent="cancel()">
                    <i class="fa-solid fa-ban me-1"></i><strong>{{ __('Cancel') }}</strong>
                </x-secondary-button>
            </div>
    </form>
</x-modal>