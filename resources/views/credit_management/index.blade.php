<x-slot name="header">
    <x-title-list icon="earth-americas">{{ __('Credit Management') }}</x-title-list>
</x-slot>

<div class="max-w-12xl py-6 mx-auto sm:px-4 lg:px-6 space-y-6">
    <div class="p-4 sm:p-8 bg-white dark:bg-secondary-800 shadow sm:rounded-lg">
        <x-session-status />
        <div class="flex flex-col">
            <div class="inline-block min-w-full">
                <div class="rounded overflow-x-auto">
                    <table class="min-w-full text-left text-sm font-light">
                        <thead class="border-b bg-secondary-800 font-medium text-white dark:border-secondary-500 dark:bg-secondary-900">
                            <tr>
                                <x-table-th title="{{ __('Account') }}" />
                                <x-table-th title="{{ __('Status') }}" />
                                <x-table-th title="{{ __('Monthly points available') }}" />
                                <x-table-th title="{{ __('Monthly accumulated points') }}" />
                                <x-table-th title="{{ __('Annual points available') }}" />
                                <x-table-th title="{{ __('Annual accumulated points') }}" />
                                <th scope="col" class="px-6 py-4">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($credit_managements as $credit_management)
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ $credit_management->email }}</x-table-td>
                                <x-table-td>{{ $credit_management->status }}</x-table-td>
                                <x-table-td>{{ $credit_management->monthly_points_available }}</x-table-td>
                                <x-table-td>{{ $credit_management->monthly_accumulated_points }}</x-table-td>
                                <x-table-td>{{ $credit_management->annual_points_available }}</x-table-td>
                                <x-table-td>{{ $credit_management->annual_accumulated_points }}</x-table-td>
                                <x-table-td>
                                    <a href="#" wire:key="recharge-reduction-{{ $credit_management->id }}" wire:click="edit({{ $credit_management->id }})" class="me-1" title="{{__('Recharge or reduction')}}">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>
                                </x-table-td>
                            </tr>
                            @empty
                            <x-table-empty colspan="6" />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $credit_managements->links() }}
                </div>
            </div>
        </div>
        @if($updateCreditManagement)
        @include('credit_management.edit')
        @endif
    </div>
</div>