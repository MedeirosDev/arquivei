<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    public function handle($request, Closure $next)
    {
        if (
            $request->header('x-api-id') === config('arquivei.api_id')
            && $request->header('x-api-key') === config('arquivei.api_key')
        ) {
            return $next($request);
        }
        return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
    }
}
