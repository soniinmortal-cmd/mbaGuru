<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckInternetConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->isConnected()) {
            return response()->view('errors.no_internet');
        }

        return $next($request);
    }

    /**
     * Check if the server is connected to the internet.
     *
     * @return bool
     */
    private function isConnected()
    {
        $connected = @fsockopen("www.google.com", 80);
        if ($connected){
            fclose($connected);
            return true;
        }
        return false;
    }
}
