<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class HttpsProtocol
 * @package App\Http\Middleware
 */
class HttpsProtocol
{
    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if (!app()->environment('local')) {
            // Handle proxies
            Request::setTrustedProxies([$request->getClientIp()]);

            if (!$request->secure()) {
                return redirect()->secure($request->getRequestUri());
            }
        }

        return $next($request);
    }
}
