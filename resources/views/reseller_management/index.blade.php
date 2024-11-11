<x-slot name="header">
    <x-title-list icon="fa-solid fa-table-list">{{ __('Reseller management') }}</x-title-list>
</x-slot>
<div class="max-w-12xl py-6 mx-auto sm:px-4 lg:px-6 space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-secondary-800 shadow sm:rounded-lg">
        <x-session-status />
        <div class="flex flex-col">
            <div class="inline-block min-w-full">
                <x-primary-button type="button" wire:click="create()" class="mb-2">
                    <i class="fa-solid fa-plus me-1"></i>{{ __('Create reseller management') }}
                </x-primary-button>
                <div class="rounded overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                            <tr>
                                <x-table-th title="{{ __('Email') }}" />
                                <x-table-th title="{{ __('Status') }}" />
                                <x-table-th title="{{ __('Date created') }}" />
                                <x-table-th title="{{ __('Observation') }}" />
                                <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $user)
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ $user->email }}</x-table-td>
                                <x-table-td>
                                @if($user->status === 1)
                                <x-bag color="bg-emerald-400"> {{ __('Active') }}</x-bag>
                                @else
                                <x-bag color="bg-red-400"> {{ __('Inactive') }}</x-bag>
                                @endif
                            </x-table-td>
                                <x-table-td>{{ $user->created_at }}</x-table-td>
                                <x-table-td>{{ $user->observation }}</x-table-td>
                                <x-table-td>
                                    <x-table-buttons-reseller id="{{ $user->id }}" />
                                </x-table-td>
                            </tr>
                            @empty
                            <x-table-empty />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
        @if($addResellerManagement)
        @include('reseller_management.create')
        @endif
        @if($updateResellerManagement)
        @include('reseller_management.edit')
        @endif
        @if($changePasswordSeeResellerManagement)
        @include('reseller_management.changePassword')
        @endif
        @if($showResellerManagement)
        @include('reseller_management.show')
        @endif
        @if($deleteResellerManagement)
        <x-table-modal-delete model="deleteResellerManagement" />
        @endif
        @if($modalConfirmDisabledResellerManagement)
        <x-table-modal-comfirm model="modalConfirmDisabledResellerManagement" method="disabledEnable()"/>
        @endif
        @if($modalRefreshPasswordResellerManagement)
        <x-table-modal-comfirm model="modalRefreshPasswordResellerManagement" method="refreshPassword()"/>
        @endif
    </div>
</div>
