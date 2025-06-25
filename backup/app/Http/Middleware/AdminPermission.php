<?php

namespace App\Http\Middleware;

use Closure;

class AdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {

        if (admin()->user()->can($permission) || admin()->user()->can('Master')) {
            return $next($request);
        } else {

            toastr()->error('ليست لديك الصلاحية');
            return back();
        }

    }
}
