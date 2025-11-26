<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class ArticleService
{
    public function __construct(protected ArticleRepository $articleRepository) {}

    public function index(): LengthAwarePaginator
    {
        return $this->articleRepository->index();
    }

    public function preferredArticles(User $user): LengthAwarePaginator
    {
        return Cache::tags('preferred-articles')->remember("user:$user->id:preferred-articles", 15 * 60, function () use ($user) {
            return $this->articleRepository->findByUserPreferences($user);
        });
    }
}
