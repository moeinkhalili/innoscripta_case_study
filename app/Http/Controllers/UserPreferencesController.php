<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Services\UserPreferenceService;
use Illuminate\Http\Response;

class UserPreferencesController extends Controller
{
    public function __construct(protected UserPreferenceService $userPreference) {}

    public function update(UpdateUserPreferenceRequest $request): Response
    {
        $this->userPreference->updateOrCreate($request);

        return response()->noContent();
    }
}
