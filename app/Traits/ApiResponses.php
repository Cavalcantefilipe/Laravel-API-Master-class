<?php

namespace App\Traits;

trait ApiResponses
{
    protected function ok($message)
    {
        return $this->successResponse($message, 200);
    }

    protected function successResponse($message, $statusCode = 200)
    {
        return response()->json(['message' => $message, 'status' => $statusCode], $statusCode);
    }

    protected function errorResponse($message, $statusCode = 400)
    {
        return response()->json(['error' => $message, 'code' => $statusCode], $statusCode);
    }
}
