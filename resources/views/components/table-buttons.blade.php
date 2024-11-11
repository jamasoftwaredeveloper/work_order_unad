@props(['id' => '', 'account'=>false, 'in_used'=>''])
<a href="#" wire:key="edit-{{ $id }}" wire:click="edit({{ $id }})" class="me-1" title="{{__('Edit account')}}">
    <i class="fa-solid fa-edit"></i>
</a>
@if($in_used != "disabled")
<a href="#" wire:key="show-{{ $id }}" wire:click="show({{ $id }})" title="{{__('Show account')}}">
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
<a href="#" wire:key="delete-{{ $id }}" wire:click="setDeleteId({{ $id }})" title="{{__('Delete account')}}">
    <i class="fa-solid fa-trash"></i>
</a>
@endif