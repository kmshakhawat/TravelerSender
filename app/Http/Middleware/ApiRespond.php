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
        $method = $request->getMethod();
        $contentType = $request->header('Content-Type');

        if (in_array($method, ['POST', 'PUT', 'PATCH'])) {
            if (!$contentType || (
                    !preg_match('#^application/json#', $contentType) &&
                    !preg_match('#^multipart/form-data#', $contentType)
                )) {
                return response()->json([
                    'success' => false,
                    'message' => 'Content-Type must be application/json or multipart/form-data'
                ], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
            }

            // Optional: validate empty JSON only when content type is JSON
            if (preg_match('#^application/json#', $contentType) && empty($request->all())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Empty or invalid JSON provided.'
                ], Response::HTTP_BAD_REQUEST);
            }
        }

        $request->headers->set('Accept', 'application/json');
        return $next($request);
    }
}
