@props(['id' => '', 'account'=>false, 'in_used'=>'disabled'])
<div class="flex flex-wrap gap-2">
    <a href="#" wire:key="edit-{{ $id }}" wire:click="edit({{ $id }})" title="{{__('Edit')}}" class="px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 active:bg-blue-700">
        <i class="fa-solid fa-edit"></i>
    </a>

    @if($in_used != "disabled")
    <a href="#" wire:key="show-{{ $id }}" wire:click="show({{ $id }})" title="{{__('Show')}}" class="px-4 py-2 font-semibold text-gray-500 border border-gray-500 rounded hover:bg-gray-500 hover:text-white">
        <i class="fa-solid fa-eye"></i>
    </a>
    @endif

    <a href="#" wire:key="delete-{{ $id }}" wire:click="setDeleteId({{ $id }})" title="{{__('Delete')}}" class="px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
        <i class="fa-solid fa-trash"></i>
    </a>
</div>
