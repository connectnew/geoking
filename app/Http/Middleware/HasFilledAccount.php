<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class HasFilledAccount extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    protected $except = [
        'profile'
    ];

    public function handle($request, Closure $next)
    {
        $ownedAccounts = auth()->user()->accounts()->count();
        if ($ownedAccounts <= 0) {
            return redirect()->route('profile');
        }
        return $next($request);
    }
}
