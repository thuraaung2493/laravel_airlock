<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends ApiController
{
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::whereEmail($request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->responseClientError('Password is wrong!', 401);
        }

        $token = $user->createToken($request->device_name, ['user:show'])->plainTextToken;

        return $this->responseSuccess($token);
    }
}
