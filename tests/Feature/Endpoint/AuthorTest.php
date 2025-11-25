<?php

namespace Feature\Endpoint;

use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    public function test_get_authors(): void
    {
        $user = User::factory()->create();
        Category::factory()->count(10)->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->get('/api/authors')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $json) {
                    $json->each(function (AssertableJson $json) {
                        $this->checkDecorator($json);
                    });
                })->etc();
            });
    }

    public function test_can_get_one_author(): void
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();

        $this->actingAs($user)
            ->withHeader('accept', 'application/json')
            ->get("/api/authors/$author->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->each(function (AssertableJson $json) {
                    $this->checkDecorator($json);
                });
            });
    }

    private function checkDecorator(AssertableJson $json): void
    {
        $json->whereAllType([
            'id' => 'integer',
            'name' => 'string',
        ]);
    }
}
