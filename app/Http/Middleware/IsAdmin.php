<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Administrators;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $dat = $request->user();
        $admin = Administrators::where('username',$dat->username)->first();
        if(!$admin){
            return response()->json(['Forbidden Access'],403);
        }
        return $next($request);
    }
}
