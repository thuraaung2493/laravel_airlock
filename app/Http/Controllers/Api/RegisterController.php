<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends ApiController
{
    public function store(UserRegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $this->responseSuccess($user, 'Signup successful.', 201);
    }
}
