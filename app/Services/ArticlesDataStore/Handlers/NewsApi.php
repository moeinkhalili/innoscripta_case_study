<?php

namespace App\Services\ArticlesDataStore\Handlers;

use App\Repositories\ArticleRepository;
use App\Services\ArticlesDataStore\Contracts\ArticleHandler;
use App\Services\ArticlesDataStore\Dto\Article;
use App\Services\ArticlesDataStore\Traits\ArticleDataStoreTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsApi implements ArticleHandler
{
    use ArticleDataStoreTrait;

    public string $url = 'https://newsapi.org/v2/';

    public function __construct(protected ArticleRepository $articleRepository) {}

    public function dataStoreName(): string
    {
        return 'news_api';
    }

    public function fetchArticles(): void
    {
        for ($page = 1; $page < 5; $page++) {
            $response = Http::get("$this->url/everything", [
                'apiKey' => config('articles.providers.newsapi.api_key'),
                'sortby' => 'popularity',
                'from' => $this->getFromDate()->toISOString(),
                'sources' => 'bild',
                'page' => $page,
                'pageSize' => 20,
            ])->throw();

            $data = $response->json();
            foreach ($data['articles'] as $article) {
                $author = $article['author'] ? explode(',', $article['author']) : '';

                $this->articleRepository->updateOrCreate(
                    new Article(
                        title: $article['title'],
                        content: $article['description'] ?? null,
                        publishedAt: Carbon::parse($article['publishedAt']),
                        category: null,
                        thumbnail: $article['urlToImage'],
                        url: $article['url'],
                        author: ! empty($author[0]) ? trim($author[0]) : $article['source']['name'] ?? 'NewsApi.org',
                        provider: $this->dataStoreName(),
                    )
                );
            }

            if (count($data['articles'] ?? []) < 10) {
                break;
            }
        }
    }
}
