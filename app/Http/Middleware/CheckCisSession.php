<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCisSession
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->session()->has('pinjam_user')) {
            return redirect()->route('mybioproses.auth')->with('error', 'Silakan login terlebih dahulu.');
        }
        return $next($request);
    }
}