<?php

namespace App\Http\Middleware;

use Closure;
use App\OAuth;

class OAuthTokenAdded
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        $accessToken = auth()->user()->oauth()->where('provider', OAuth::GOOGLE)->get();
        if ($accessToken->isEmpty()) {
            return redirect()->route('integrations')->withErrors(['msg' => 'Integration required']);
        }
            
        return $next($request);
    }
}
