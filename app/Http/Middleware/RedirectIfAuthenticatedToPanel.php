<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticatedToPanel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return redirect('/admin');
            } elseif ($user->hasRole('dosen_pembimbing')) {
                return redirect('/pembimbing');
            } elseif ($user->hasRole('mahasiswa')) {
                return redirect('/mahasiswa');
            }
        }

        return $next($request);
    }
}
