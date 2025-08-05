<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TransformApiResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $content = json_decode($response->getContent(), true);
        $success = (bool)$response->isSuccessful();
        $statusCode = $response->getStatusCode();
        $error = '';

        if (!$success) {
            $error = $content['message'] ?? $content['meta']['error'] ?? '';
            $content = [];
        }

        $response->setContent(json_encode(
            self::getResponseWrap($success, $content, $error)
        ));

        $response->setStatusCode($statusCode);

        return $response;
    }


    /**
     * @param bool $success
     * @param string $message
     * @return array[]
     */
    public static function getResponseWrap($success, $data, $error = '')
    {
        return [
            'meta' => [
                'success' => $success,
                'error' => $error
            ],
            'data' => $data
        ];
    }

    public static function parseTrace($trace)
    {
        return array_map(function ($elem) {
            return ($elem['file'] ?? '') . '->' . ($elem['function'] ?? '') . ' line: ' . ($elem['line'] ?? '');
        }, $trace);
    }
}
