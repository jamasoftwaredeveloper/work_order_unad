<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class VerifyUserInactiveListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Authenticated $event)
    {
        $user = $event->user;

        if (!$user->isActive()) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);

        }
    }
}
