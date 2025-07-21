<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiRespond
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            $contentType = $request->header('Content-Type');

            // Check if Content-Type is application/json
            if (!$contentType || !preg_match('#^application/json#', $contentType)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Content-Type must be application/json'
                ], Response::HTTP_UNSUPPORTED_MEDIA_TYPE); // 415
            }

            // Check if JSON is empty or invalid (for POST, PUT, PATCH)
            if ($request->isJson() && empty($request->all())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empty or invalid JSON provided.'
                ], Response::HTTP_BAD_REQUEST); // 400
            }
        }

        $request->headers->set('Accept', 'application/json');

        // Allow GET and other methods without Content-Type check
        return $next($request);
    }
}
