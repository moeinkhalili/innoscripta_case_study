<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $articleService) {}

    public function index(): ArticleCollection
    {
        return new ArticleCollection($this->articleService->index());
    }

    public function show(Article $article): ArticleResource
    {
        return new ArticleResource($article);
    }

    public function preferredArticles(): ArticleCollection
    {
        return new ArticleCollection($this->articleService->preferredArticles(request()->user()));
    }
}
