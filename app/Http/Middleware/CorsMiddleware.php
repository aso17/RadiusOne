<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CorsMiddleware
{
   public function handle(Request $request, Closure $next): Response
    {
        $origin = $request->headers->get('Origin');

        if (!$origin) {
            return $next($request);
        }

        $host = parse_url($origin, PHP_URL_HOST);

        // ✅ DEV MODE
        if (in_array($host, ['localhost', '127.0.0.1'])) {
            return $this->handleAllowed($request, $next, $origin);
        }

        // ✅ PROD MODE (tenant based)
        $isAllowed = DB::table('_ms_tenants')
            ->where('domain', $host)
            ->where('is_active', true)
            ->exists();

        if (!$isAllowed) {
            return response()->json(['message' => 'CORS forbidden'], 403);
        }

        return $this->handleAllowed($request, $next, $origin);
    }

    private function handleAllowed(Request $request, Closure $next, string $origin): Response
    {
        if ($request->getMethod() === 'OPTIONS') {
            return response('', 204)
                ->header('Access-Control-Allow-Origin', $origin)
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
                ->header('Access-Control-Allow-Credentials', 'true');
        }

        $response = $next($request);

        return $response
            ->header('Access-Control-Allow-Origin', $origin)
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization')
            ->header('Access-Control-Allow-Credentials', 'true');
    }

}
