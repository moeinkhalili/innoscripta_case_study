<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\ArticleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleService
{
    public function __construct(protected ArticleRepository $articleRepository) {}

    public function index(): LengthAwarePaginator
    {
        return $this->articleRepository->index();
    }

    public function preferredArticles(User $user): LengthAwarePaginator
    {
        return $this->articleRepository->findByUserPreferences($user);
    }
}
