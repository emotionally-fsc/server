<?php

namespace Emotionally\Http\Middleware;

use Closure;
use Illuminate\Http\Resources\Json\Resource;
use Symfony\Component\Console\Output\ConsoleOutput;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $locale = \Session::get('locale', config('app.fallback_locale'));

        \App::setLocale($locale);
        return $next($request);
    }
}
