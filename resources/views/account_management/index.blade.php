<x-slot name="header">
    <x-title-list icon="fa-regular fa-rectangle-list">{{ __('Account management') }}</x-title-list>
</x-slot>

<div class="max-w-12xl py-6 mx-auto sm:px-4 lg:px-6 space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-secondary-800 shadow sm:rounded-lg">
        <x-session-status />
        <div class="flex flex-col">
            <div class="inline-block min-w-full">
                <x-primary-button type="button" wire:click="create()" class="mb-2">
                    <i class="fa-solid fa-plus me-1"></i>{{ __('Create Account') }}
                </x-primary-button>
                <div class="rounded overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                            <tr>
                                <x-table-th title="{{ __('Id') }}" />
                                <x-table-th title="{{ __('Account') }}" />
                                <x-table-th title="{{ __('Password') }}" />
                                <x-table-th title="{{ __('Remaining days in credits') }}" />
                                <x-table-th title="{{ __('Buyer name') }}" />
                                <x-table-th title="{{ __('Time of first access') }}" />
                                <x-table-th title="{{ __('Account due date') }}" />
                                <x-table-th title="{{ __('In use') }}" />
                                <x-table-th title="{{ __('Expired') }}" />
                                <x-table-th title="{{ __('Operator') }}" />
                                <x-table-th title="{{ __('Date created') }}" />
                                <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($account_managements as $account_management)
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ $account_management->id }}</x-table-td>
                                <x-table-td>{{ $account_management->account }}</x-table-td>
                                <x-table-td>{{ $account_management->password }}</x-table-td>
                                <x-table-td>{{ $account_management->days_remaining_credits }}</x-table-td>
                                <x-table-td>{{ $account_management->buyer_name }}</x-table-td>
                                <x-table-td>{{ $account_management->initial_creation_date }}</x-table-td>
                                <x-table-td>{{ $account_management->final_expiration_date }}</x-table-td>
                                <x-table-td>
                                    @if ($account_management->in_used === "not_used" || $account_management->in_used === "used")
                                    <x-bag color="bg-emerald-400">{{ __($account_management->in_used) }}</x-bag>
                                    @endif
                                    @if ($account_management->in_used === "disabled")
                                    <x-bag color="bg-red-400">{{ __($account_management->in_used) }}</x-bag>
                                    @endif
                                </x-table-td>
                                <x-table-td>
                                    @if ($account_management->expired === "not_expired")
                                    <x-bag color="bg-emerald-400">{{ __($account_management->expired) }}</x-bag>
                                    @endif
                                    @if ($account_management->expired === "expired")
                                    <x-bag color="bg-red-400">{{ __($account_management->expired) }}</x-bag>
                                    @endif
                                </x-table-td>
                                <x-table-td>{{ $account_management->user->first_name }} {{ $account_management->user->last_name }}</x-table-td>
                                <x-table-td>{{ $account_management->created_at }}</x-table-td>
                                <x-table-td>
                                    <x-table-buttons id="{{ $account_management->id }}" account="{{true}}" in_used="{{$account_management->in_used}}" />
                                </x-table-td>
                            </tr>
                            @empty
                            <x-table-empty />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $account_managements->links() }}
                </div>
            </div>
        </div>
        @if($addAccountManagement)
        @include('account_management.create')
        @endif
        @if($updateAccountManagement)
        @include('account_management.edit')
        @endif
        @if($showAccountManagement)
        @include('account_management.show')
        @endif
        @if($changePasswordSee)
        @include('account_management.changePassword')
        @endif
        @if($deleteAccountManagement)
        <x-table-modal-delete model="deleteAccountManagement" />
        @endif
        @if($modalConfirmDisabled)
        <x-table-modal-comfirm model="modalConfirmDisabled" method="disabledEnable()"/>
        @endif
        @if($modalRefreshPassword)
        <x-table-modal-comfirm model="modalRefreshPassword" method="refreshPassword()"/>
        @endif
    </div>
</div>