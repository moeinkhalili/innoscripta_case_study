<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use App\Models\User;
use App\Models\UserPreference;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use App\Services\ArticlesDataStore\Dto\Article as ArticleDto;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function index(): LengthAwarePaginator
    {
        return Article::query()->paginate();
    }

    public function findByUserPreferences(User $user): LengthAwarePaginator
    {
        $userPreference = UserPreference::query()->where('user_id', $user->id)->first();

        if (! $userPreference || (! $userPreference->preferred_author_id && ! $userPreference->preferred_category_id)) {
            return $this->index();
        }

        $query = Article::query()->orderBy('published_at', 'DESC');

        if ($userPreference->preferred_author_id) {
            $query->where('author_id', $userPreference->preferred_author_id);
        }

        if ($userPreference->preferred_category_id) {
            $query->orWhere('category_id', $userPreference->preferred_category_id);
        }

        return $query->paginate();
    }

    public function updateOrCreate(ArticleDto $article): Article
    {
        return Article::query()->updateOrCreate([
            'published_at' => $article->publishedAt,
            'provider' => $article->provider,
        ], [
            'title' => $article->title,
            'body' => $article->content,
            'url' => $article->url,
            'published_at' => $article->publishedAt,
            'category_id' => $article->category ? Category::query()->firstOrCreate(['name' => $article->category])->id : null,
            'author_id' => $article->author ? Author::query()->firstOrCreate(['name' => $article->author])->id : null,
            'thumbnail' => $article->thumbnail,
            'provider' => $article->provider,
        ]);
    }
}
