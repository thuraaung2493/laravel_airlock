<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function responseSuccess($data = [], String $message = null, Int $status = 200): JsonResponse
    {
        return response()->json([
            'code' => $status,
            'message' => $message ?? 'Success.',
            'data' => $data,
        ], $status);
    }

    public function responseClientError(String $message = null, Int $status = 400): JsonResponse
    {
        return response()->json([
            'code' => $status,
            'message' => $message ?? 'Bad Request',
        ], $status);
    }
}
