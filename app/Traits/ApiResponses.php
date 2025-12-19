<?php

namespace App\Traits;

trait ApiResponses
{
    protected function ok($message, $data)
    {
        return $this->successResponse($message, $data, 200);
    }

    protected function successResponse($message, $data = null, $statusCode = 200)
    {
        return response()->json(['data' => $data, 'message' => $message, 'status' => $statusCode], $statusCode);
    }

    protected function error($message, $statusCode = 400)
    {
        return response()->json(['error' => $message, 'status' => $statusCode], $statusCode);
    }
}
