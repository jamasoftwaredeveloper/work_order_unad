@props(['model' => '', 'method'=>''])
{{$model}}
<x-modal wire:model="{{ $model }}" focusable
    :title="__('Are you sure you want to make the following change?')">

    <p class="mt-1 text-sm text-txtdark-600">
        {{ __('Once the record has been modified, it will be displayed in a few seconds.') }}
    </p>

    <div class="mt-6 flex justify-end gap-4">
        <x-secondary-button wire:click.prevent="cancel()">
            <i class="fa-solid fa-ban me-1"></i>{{ __('Cancel') }}
        </x-secondary-button>
        <x-primary-button type="button" wire:click.prevent="{{$method}}">
            <i class="fa-solid fa-save me-1"></i>{{ __('Update') }}
        </x-primary-button>
    </div>
</x-modal>