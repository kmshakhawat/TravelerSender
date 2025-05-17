<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OTP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()?->hasRole('admin')) {
            return $next($request);
        }
        if (auth()->check()) {
            $user = auth()->user();
            // If OTP is not verified or has expired, redirect to OTP verification
            if (!$user->hasValidOtp()) {
                return redirect()->route('otp')->with('message', 'Please verify your OTP');
            }
        }

        return $next($request);

    }
}
