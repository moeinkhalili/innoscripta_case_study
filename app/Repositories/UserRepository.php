<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function create(string $name, string $email, string $password): User
    {
        return User::query()->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }
}
