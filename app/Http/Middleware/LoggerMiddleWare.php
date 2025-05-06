<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LoggerMiddleWare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        Log::info('Route called', [
            'method' => $request->getMethod(),
            'url' => $request->getPathInfo(),
            'status' => $response->status(),
            'ip' => $request->ip(),
            'referer' => $request->headers->get('referer'),
            'query' => $request->query(),
        ]);
        return $response;
    }
}
