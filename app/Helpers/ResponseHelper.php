<?php

namespace App\Helpers;

use Illuminate\Http\Response;

trait ResponseHelper
{
    /**
     * Build success response
     * @param string $message
     * @param string|array $data
     * @param int @code
     * @return illuminate\Http\JsonResponse
     */
    public function successResponse($message, $data = [], $code = Response::HTTP_OK) {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * Build error response
     * @param string|array $message
     * @param int @code
     * @return illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'error_code' => $code
        ], $code);
    }
}