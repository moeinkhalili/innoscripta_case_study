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
        $author = Author::factory()->create();
        $category = Category::factory()->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->put('/api/user-preferences', [
                'preferred_author_id' => $author->id,
                'preferred_category_id' => $category->id,
            ])
            ->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertDatabaseHas('user_preferences', [
            'user_id' => $user->id,
            'preferred_author_id' => $author->id,
            'preferred_category_id' => $category->id,
        ]);
    }
}
