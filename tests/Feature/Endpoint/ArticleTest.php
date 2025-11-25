<?php

namespace Feature\Endpoint;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use App\Models\UserPreference;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    public function test_get_articles(): void
    {
        $user = User::factory()->create();
        Article::factory()->count(10)->create();

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->get('/api/articles')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', function (AssertableJson $json) {
                    $json->each(function (AssertableJson $json) {
                        $this->checkCollectionResource($json);
                    });
                })->etc();
            });
    }

    public function test_can_get_one_article(): void
    {
        $user = User::factory()->create();
        $article = Article::factory()->create();

        $this->actingAs($user)
            ->withHeader('accept', 'application/json')
            ->get("/api/articles/$article->id")
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) {
                $json->each(function (AssertableJson $json) {
                    $this->checkSingleResource($json);
                });
            });
    }

    public function test_can_get_preferred_articles()
    {
        $user = User::factory()->create();
        $author = Author::factory()->create();
        $category = Category::factory()->create();
        UserPreference::query()->create([
            'user_id' => $user->id,
            'preferred_author_id' => $author->id,
            'preferred_category_id' => $category->id,
        ]);
        Article::factory()->count(10)->create();
        Article::factory()->count(2)->create(['author_id' => $author->id]);
        Article::factory()->count(2)->create(['category_id' => $category->id]);

        $this
            ->withHeader('Accept', 'application/json')
            ->actingAs($user, 'sanctum')
            ->get('/api/preferred-articles')
            ->assertStatus(Response::HTTP_OK)
            ->assertJson(function (AssertableJson $json) use ($author, $category) {
                $json->has('data', function (AssertableJson $json) use ($author, $category) {
                    $json->count(4)
                        ->each(function (AssertableJson $json) use ($author, $category) {
                            $this->checkCollectionResource($json);
                            $data = $json->toArray();
                            $this->assertTrue($author->id === $data['author_id'] || $category->id === $data['category_id']);
                        });
                })->etc();
            });
    }

    private function checkSingleResource(AssertableJson $json): void
    {
        $json->whereAllType([
            'id' => 'integer',
            'title' => 'string',
            'body' => 'string',
            'url' => 'string',
            'thumbnail' => 'string',
            'published_at' => 'string',
            'provider' => 'string',
            'author' => 'array',
            'category' => 'array',
        ]);
    }

    private function checkCollectionResource(AssertableJson $json): void
    {
        $json->whereAllType([
            'id' => 'integer',
            'title' => 'string',
            'body' => 'string',
            'url' => 'string',
            'thumbnail' => 'string',
            'published_at' => 'string',
            'provider' => 'string',
            'author_id' => 'integer',
            'category_id' => 'integer|null',
        ]);
    }
}
