<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use App\Models\UserPreference;

interface UserPreferenceRepositoryInterface
{
    public function updateOrCreate(User $user): UserPreference;
}
