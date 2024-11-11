<?php

namespace App\Http\Livewire;

use App\Models\RegisterOperation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Title;
use Livewire\Component;

class RegisterOperations extends Component
{
    public $type, $observation, $result, $status, $user_id;
    protected $listeners = ['render'];
    #[Title('Register Operation')]
    public function render()
    {
        $user = Auth::user();
        $hasRole = User::find($user->id)->roles()->where('title', 'Super Admin')->exists();
        $registerOperations  = RegisterOperation::orderBy('type', 'asc')->paginate(15);
        if(!$hasRole){
            $account_managements = RegisterOperation::where('user_id', $user->id)->orderBy('account', 'asc')->paginate(15);
        }
        return view('register_operation.index', compact('registerOperations'));
    }

    public function mount()
    {
        if (Gate::denies('reseller_management_index')) {
            return redirect()->route('dashboard')
                ->with('message', trans('message.You do not have the necessary permissions to execute the action.'))
                ->with('alert_class', 'danger');
        }
    }
}
