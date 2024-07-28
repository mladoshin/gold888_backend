<?php

namespace App\Traits;

trait ApiResponse
{
    public function successResponse($data = [], $statusCode = 200)
    {
        return response()->json(['success' => true, 'data' => $data], $statusCode);
    }

    public function errorResponse($message = null, $statusCode = 500)
    {
        return response()->json(['success' => false, 'message' => $message], $statusCode);
    }

}
