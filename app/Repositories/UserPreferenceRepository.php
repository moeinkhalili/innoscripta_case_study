<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserPreference;
use App\Repositories\Contracts\UserPreferenceRepositoryInterface;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    public function updateOrCreate(User $user, ?int $authorId = null, ?int $categoryId = null): UserPreference
    {
        return UserPreference::query()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'preferred_author_id' => $authorId,
            'preferred_category_id' => $categoryId,
        ]);
    }
}
