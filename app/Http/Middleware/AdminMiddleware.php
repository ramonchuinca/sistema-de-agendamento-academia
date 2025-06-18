<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
  public function handle($request, Closure $next)
{
    if ($request->user() && $request->user()->is_admin) {
        return $next($request);
    }

    return response()->json(['message' => 'Acesso não autorizado.'], 403);
}


}
