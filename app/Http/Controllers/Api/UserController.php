<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\JsonResponse;

class UserController extends ApiController
{
    public function show(User $user): JsonResponse
    {
        if (! $this->hasPermission($user, 'user:show')) {
            return $this->responseClientError('Forbidden', 403);
        }

        return $this->responseSuccess($user, 'Get a user success.');
    }

    public function update(User $user): JsonResponse
    {
        if (! $this->hasPermission($user, 'user:update')) {
            return $this->responseClientError('Forbidden', 403);
        }

        $user->update(request()->only(['name', 'email']));

        return $this->responseSuccess($user, 'Updated success.');
    }

    public function destroy(User $user): JsonResponse
    {
        if (! $this->hasPermission($user, 'user:delete')) {
            return $this->responseClientError('Forbidden', 403);
        }

        $user->tokens()->delete();
        $user->delete();

        return $this->responseSuccess([], 'Deleted success.');
    }

    protected function hasPermission(User $user, String $ability): bool
    {
        $userFromToken = request()->user();

        return $userFromToken->is($user) && $userFromToken->tokenCan($ability);
    }
}
