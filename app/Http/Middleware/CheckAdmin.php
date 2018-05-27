<?php

namespace DLG\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
{

    public function handle($request, Closure $next)
    {
        if (!Auth::check())
        {
            return redirect('unauthorized');
        }

        return $next($request);
    }
}
