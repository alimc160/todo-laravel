<?php

namespace App\Traits;


trait ApiResponseTrait
{
    public function successResponse($status = 200, $message = null, $data = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ],$status);
    }

    public function errorResponse($status = 400, $message=null)
    {
        response()->json([
            'status' => $status,
            'message' => $message
        ],$status)->throwResponse();
    }
}
