<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function signUp(SignUpRequest $request): array
    {
        return $this->userService->signUp($request);
    }

    public function signIn(SignInRequest $request): array
    {
        return $this->userService->signIn($request);
    }

    public function signOut(Request $request): Response
    {
        $this->userService->signOut($request);

        return response()->noContent();
    }

    public function currentUser(): UserResource
    {
        return new UserResource($this->userService->currentUser());
    }
}
