<x-slot name="header">
  <h2 class="font-semibold text-xl text-txtdark-800 dark:text-txtdark-200 leading-tight">
    {{ __('Dashboard') }}
  </h2>
</x-slot>
<div class="py-12">
  <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-secondary-800 overflow-hidden shadow-xl sm:rounded-lg">
      <div class="p-6 text-txtdark-900 dark:text-txtdark-100">
        <div class="grid-cols-1 sm:grid md:grid-cols-12 lg:grid-cols-6">
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("Total accounts")}} <p class="text-lg" style="color:darkgrey">{{ __('Total accounts created') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$total_accounts}}</b> <i class="fa-solid fa-image-portrait fa-2xl" style="color:blue"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("Valid accounts")}} <p class="text-lg" style="color:darkgrey">{{ __('Non expired') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$valid_accounts}}</b><i class="fa-solid fa-user-group fa-2xl" style="color:green"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("Expired accounts")}} <p class="text-lg" style="color:darkgrey">{{ __('Expired') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$expired_accounts}}</b><i class="fa-solid fa-user-large-slash fa-2xl" style="color:red"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("Nº of unsold accounts")}} <p class="text-lg" style="color:darkgrey">{{ __('Unused') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$monthly_points_available}}</b><i class="fa-solid fa-users fa-2xl" style="color:orange"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight" > {{ __("Today")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of accounts activated today') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$today}}</b><i class="fa-regular fa-lightbulb fa-2xl" style="color:orange"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This week")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of accounts activated this week') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_week}}</b><i class="fa-regular fa-lightbulb fa-2xl" style="color:orange"></i>
              </p>
            </div>
          </div>
        </div>
        <div class="grid-cols-1 sm:grid md:grid-cols-12 lg:grid-cols-6">
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This month")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº accounts activated this month') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_month}}</b><i class="fa-regular fa-lightbulb fa-2xl" style="color:orange"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This year")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of accounts activated this year') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_year}}</b><i class="fa-regular fa-lightbulb fa-2xl" style="color:orange"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("Today")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of renewals today') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$today_renewals}}</b> <i class="fa-solid fa-tag fa-2xl" style="color:green"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This week")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of renewals this week') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_week_renewals}}</b><i class="fa-solid fa-tag fa-2xl" style="color:green"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This month")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº renewals this month') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_month_renewals}}</b><i class="fa-solid fa-tag fa-2xl" style="color:green"></i>
              </p>
            </div>
          </div>
          <div class="mx-3 mt-6 flex flex-col rounded-2xl bg-white text-surface shadow-secondary-1 shadow-xl dark:bg-surface-dark dark:text-white sm:shrink-0 sm:grow sm:basis-0">
            <div class="p-6">
              <h5 class="mb-2 text-xl font-medium leading-tight"> {{ __("This year")}} <p class="text-lg" style="color:darkgrey">{{ __('Nº of renewals this year') }}</p></h5>
              <p class="mb-4 text-2xl text-end mt-4">
                <b style="float: left">{{$this_year_renewals}}</b><i class="fa-solid fa-tag fa-2xl" style="color:green"></i>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>
