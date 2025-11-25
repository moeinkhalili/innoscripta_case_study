<?php

namespace App\Services;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository) {}

    public function signUp(SignUpRequest $request): array
    {
        $data = $request->validated();

        $user = $this->userRepository->create($data['name'], $data['email'], $data['password']);
        event(new Registered($user));

        return [
            'token' => $user->createToken('token')->plainTextToken,
        ];
    }

    public function signIn(SignInRequest $request): array
    {
        $data = $request->validated();

        $user = $this->userRepository->findByEmail($data['email']);
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            abort(401, 'Invalid credentials');
        }

        return [
            'token' => $user->createToken('token')->plainTextToken,
        ];
    }

    public function signOut(Request $request): void
    {
        $request->user()->currentAccessToken()?->delete();
    }

    public function currentUser(): ?Authenticatable
    {
        return Auth::user();
    }
}
