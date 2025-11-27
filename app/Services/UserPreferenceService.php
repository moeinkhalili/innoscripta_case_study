<?php

namespace App\Services;

use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Models\UserPreference;
use App\Repositories\AuthorRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserPreferenceRepository;

class UserPreferenceService
{
    public function __construct(
        protected UserPreferenceRepository $userPreferenceRepository,
        protected AuthorRepository $authorRepository,
        protected CategoryRepository $categoryRepository,
    ) {}

    public function updateOrCreate(UpdateUserPreferenceRequest $request): UserPreference
    {
        $data = $request->validated();

        return $this->userPreferenceRepository->updateOrCreate(
            $request->user(),
            $data['preferred_author_id'] ?? null,
            $data['preferred_category_id'] ?? null,
        );
    }
}
