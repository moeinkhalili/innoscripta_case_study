<?php

namespace App\Services\ArticlesDataStore\Contracts;

interface ArticleHandler
{
    public function dataStoreName(): string;

    public function fetchArticles(): void;
}
