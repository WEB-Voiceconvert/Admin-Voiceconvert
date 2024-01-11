<?php

namespace App\Http\Middleware;

use App\Models\Alat;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Symfony\Component\HttpFoundation\Response;

class AlatAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $alat = Alat::where('id', $request->uuid)->first();
        if (Hash::check($request->api_key, $alat->api_key)) {
            return $next($request);
        }

        return FacadesResponse::json([
            'meta' => [
                'code' => 401,
                'status' => 'failed',
                'message' => 'Unauthorized.',
            ],
        ], 401);
    }
}
