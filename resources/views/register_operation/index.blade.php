<x-slot name="header">
    <x-title-list icon="map-location-dot">{{ __('Register Operation') }}</x-title-list>
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
                                <x-table-th title="{{ __('Type') }}" />
                                <x-table-th title="{{ __('Observation') }}" />
                                <x-table-th title="{{ __('Status') }}" />
                                <x-table-th title="{{ __('Result') }}" />
                                <x-table-th title="{{ __('Operator') }}" />
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($registerOperations as $registerOperation)
                            <tr class="border-b transition duration-300 ease-in-out hover:bg-secondary-100 dark:border-secondary-500 dark:hover:bg-secondary-600">
                                <x-table-td>{{ __($registerOperation->type) }}</x-table-td>
                                <x-table-td>{{ $registerOperation->observation }}</x-table-td>
                                <x-table-td>
                                    @if ($registerOperation->status === "complete_process")
                                    <x-bag color="bg-emerald-400">{{ __($registerOperation->status) }}</x-bag>
                                    @else
                                    <x-bag color="bg-red-400"> {{ __($registerOperation->status) }}</x-bag>
                                    @endif

                                </x-table-td>
                                <x-table-td>
                                    @if ($registerOperation->result === "successful")
                                    <x-bag color="bg-emerald-400"> {{ __($registerOperation->result) }}</x-bag>
                                    @else
                                    <x-bag color="bg-red-400"> {{ __($registerOperation->result) }}</x-bag>
                                    @endif
                                </x-table-td>
                                <x-table-td>{{ $registerOperation->user->email }}</x-table-td>
                            </tr>
                            @empty
                            <x-table-empty />
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-2">
                    {{ $registerOperations->links() }}
                </div>
            </div>
        </div>
    </div>
</div>