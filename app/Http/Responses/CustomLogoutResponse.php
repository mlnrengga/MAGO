<?php
// app/Http/Responses/CustomLogoutResponse.php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\LogoutResponse as BaseLogoutResponse;
use Illuminate\Http\RedirectResponse;

class CustomLogoutResponse extends BaseLogoutResponse
{
    public function toResponse($request): RedirectResponse
    {
        // Arahkan kembali ke login manual
        return redirect('/login');
    }
}
