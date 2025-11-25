<?php

namespace Feature\Endpoint;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserPreferenceTest extends TestCase
{
    public function test_change_user_preferences(): void
    {
        $user = User::factory()->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->put('/api/user-preferences', [
                'preferred_author_id' => Author::factory()->create()->id,
                'preferred_category_id' => Category::factory()->create()->id,
            ])
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
