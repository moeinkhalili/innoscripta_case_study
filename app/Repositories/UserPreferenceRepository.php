<?php

namespace App\Repositories;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use App\Models\UserPreference;
use App\Repositories\Contracts\UserPreferenceRepositoryInterface;

class UserPreferenceRepository implements UserPreferenceRepositoryInterface
{
    public function updateOrCreate(User $user, ?Author $author = null, ?Category $category = null): UserPreference
    {
        return UserPreference::query()->updateOrCreate([
            'user_id' => $user->id,
        ], [
            'preferred_author_id' => $author->id ?? null,
            'preferred_category_id' => $category->id ?? null,
        ]);
    }
}
