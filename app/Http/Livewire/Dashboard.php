<?php

namespace App\Http\Livewire;

use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    protected $listeners = ['render'];
    #[Title('Dashboard')]
    public function render()
    {
        return view('dashboard');
    }
}
