<?php

namespace Feature\Endpoint;

use App\Models\Category;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_get_categories(): void
    {
        $user = User::factory()->create();
        Category::factory()->count(10)->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->get('/api/categories')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $json) {
                    $json->each(function (AssertableJson $json) {
                        $this->checkDecorator($json);
                    });
                })->etc();
            });
    }

    public function test_can_get_one_category(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)
            ->withHeader('accept', 'application/json')
            ->get("/api/categories/$category->id")
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
