<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Support\Facades\Auth;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = Auth::user();

        // 1. STRICT CHECK: Only 'super_admin' goes to the backend
        if ($user->profile_type === 'super_admin') {
            return redirect()->intended('/admin');
        }

        // 2. ALL other types (vendor, consultant, customer, dealer) go to the Dashboard
        return redirect()->route('dashboard');
    }
}