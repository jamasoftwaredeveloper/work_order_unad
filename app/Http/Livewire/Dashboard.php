<?php

namespace App\Http\Livewire;

use App\Models\AccountManagement;
use App\Models\User;
use Carbon\Carbon;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    protected $listeners = ['render'];
    #[Title('Dashboard')]
    public function render()
    {
        $user_id = Auth::user()->id;
        $startWeek = Carbon::now()->startOfWeek()->toDateString();
        $endWeek = Carbon::now()->endOfWeek()->toDateString();
        $hasRole = User::find($user_id)->roles()->where('title', 'Super Admin')->exists();
        $monthly_points_available = __('Unlimited');
        $total_accounts = AccountManagement::count();
        $valid_accounts =  AccountManagement::where('status', 1)->count();
        $expired_accounts = AccountManagement::where('status', 0)->count();
        $today = AccountManagement::where('in_used', 'used')->whereDate('created_at', now()->toDateString())->count();
        $this_week = AccountManagement::where('in_used', 'used')->whereBetween('created_at', [$startWeek, $endWeek])->count();
        $this_month = AccountManagement::where('in_used', 'used')->whereDate('created_at', now()->month)->count();
        $this_year = AccountManagement::where('in_used', 'used')->whereDate('created_at',  now()->year)->count();
        $today_renewals = AccountManagement::whereDate('initial_creation_date', now()->toDateString())->count();
        $this_week_renewals = AccountManagement::whereBetween('initial_creation_date', [$startWeek, $endWeek])->count();
        $this_month_renewals = AccountManagement::whereDate('initial_creation_date', now()->month)->count();
        $this_year_renewals = AccountManagement::whereDate('initial_creation_date',  now()->year)->count();

        if (!$hasRole) {
            $valid_accounts =  AccountManagement::where('user_id', $user_id)->where('status', 1)->count();
            $expired_accounts =  AccountManagement::where('user_id', $user_id)->where('status', 0)->count();
            $monthly_points_available = Auth::user()->monthly_points_available;
            $total_accounts = AccountManagement::where('user_id', $user_id)->count();
            $today = AccountManagement::where('in_used', 'used')->where('user_id', $user_id)->whereDate('created_at', now()->toDateString())->count();
            $this_week = AccountManagement::where('in_used', 'used')->where('user_id', $user_id)->whereBetween('created_at', [$startWeek, $endWeek])->count();
            $this_month = AccountManagement::where('in_used', 'used')->where('user_id', $user_id)->whereDate('created_at', now()->month)->count();
            $this_year = AccountManagement::where('in_used', 'used')->where('user_id', $user_id)->whereDate('created_at',  now()->year)->count();
            $today_renewals = AccountManagement::where('user_id', $user_id)->whereDate('initial_creation_date', now()->toDateString())->count();
            $this_week_renewals = AccountManagement::where('user_id', $user_id)->whereBetween('initial_creation_date', [$startWeek, $endWeek])->count();
            $this_month_renewals = AccountManagement::where('user_id', $user_id)->whereDate('initial_creation_date', now()->month)->count();
            $this_year_renewals = AccountManagement::where('user_id', $user_id)->whereDate('initial_creation_date',  now()->year)->count();
        }


        return view('dashboard', compact('monthly_points_available', 'total_accounts', 'valid_accounts', 'expired_accounts','today','this_week','this_month','this_year','today_renewals','this_week_renewals','this_month_renewals','this_year_renewals'));
    }
}
