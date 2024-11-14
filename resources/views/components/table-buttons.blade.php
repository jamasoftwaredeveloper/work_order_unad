@props(['id' => '', 'account'=>false, 'in_used'=>''])
<a href="#" wire:key="edit-{{ $id }}" wire:click="edit({{ $id }})" title="{{__('Edit')}}" class="me-1 px-4 py-2 font-semibold text-white bg-blue-500 rounded hover:bg-blue-600 active:bg-blue-700">
    <i class="fa-solid fa-edit"></i>
</a>
@if($in_used != "disabled")
<a href="#" wire:key="show-{{ $id }}" wire:click="show({{ $id }})" title="{{__('Show')}}" class="me-1 px-4 py-2 font-semibold text-gray-500 border border-gray-500 rounded hover:bg-gray-500 hover:text-white">
    <i class="fa-solid fa-eye"></i>
</a>
@endif
@if($account)
@if($in_used != "disabled")
<a href="#" wire:key="refresh-password-{{ $id }}" wire:click="setModelConfirmId({{ $id }},'refreshPassword')" title="{{__('Refresh password')}}">
    <i class="fa-solid fa-key"></i>
</a>
<a href="#" wire:key="change-password-{{ $id }}" wire:click="changePasswordForm({{ $id }})" title="{{__('Change password')}}">
    <i class="fa-solid fa-lock"></i>
</a>
@endif
<a href="#" wire:key="disabledEnable-{{ $id }}" wire:click="setModelConfirmId({{ $id }},'disabledEnable')" title="{{$in_used != 'disabled' ? __('Disabled account'):__('Enable account')}}">
    @if($in_used === "disabled")
    <i class="fa-regular fa-circle-check"></i>
    @else
    <i class="fa-solid fa-ban"></i>
    @endif
</a>
@endif
@if($in_used != "disabled")
<a href="#" wire:key="delete-{{ $id }}" wire:click="setDeleteId({{ $id }})" title="{{__('Delete')}}" class="me-1 px-4 py-2 font-semibold text-white bg-red-500 rounded hover:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
    <i class="fa-solid fa-trash"></i>
</a>
@endif
