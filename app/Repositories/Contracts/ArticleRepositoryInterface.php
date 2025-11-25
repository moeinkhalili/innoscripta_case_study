<?php

namespace App\Repositories\Contracts;

use App\Services\ArticlesDataStore\Dto\Article;
use Illuminate\Pagination\LengthAwarePaginator;

interface ArticleRepositoryInterface
{
    public function index(): LengthAwarePaginator;

    public function updateOrCreate(Article $article): \App\Models\Article;
}
