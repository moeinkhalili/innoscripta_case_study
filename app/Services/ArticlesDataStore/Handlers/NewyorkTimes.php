<?php

namespace App\Services\ArticlesDataStore\Handlers;

use App\Repositories\ArticleRepository;
use App\Services\ArticlesDataStore\Concerns\ArticleDataStoreTrait;
use App\Services\ArticlesDataStore\Contracts\ArticleHandler;
use App\Services\ArticlesDataStore\Dto\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewyorkTimes implements ArticleHandler
{
    use ArticleDataStoreTrait;

    public string $url = 'https://api.nytimes.com';

    public function __construct(protected ArticleRepository $articleRepository) {}

    public function dataStoreName(): string
    {
        return 'newyork_times';
    }

    public function fetchArticles(): void
    {
        for ($page = 1; $page <= 3; $page++) {
            $response = Http::get("$this->url/svc/search/v2/articlesearch.json", [
                'api-key' => config('articles.providers.newyorktimes.api_key'),
                'begin_date' => $this->getFromDate()->format('Ymd'),
                'page' => $page,
                'sort' => 'newest',
            ])->throw();

            $json = $response->json();

            foreach ($json['response']['docs'] ?? [] as $article) {
                $byline = $article['byline']['original'] ?? '';
                $this->articleRepository->updateOrCreate(
                    new Article(
                        title: $article['headline']['main'],
                        content: $article['abstract'],
                        publishedAt: Carbon::parse($article['pub_date']),
                        category: $article['section_name'] ?? 'Common',
                        thumbnail: $article['urlToImage'] ?? '',
                        url: $article['uri'],
                        author: preg_replace('/^By\s+/i', '', trim($byline)) ?? 'Newyorktimes.com',
                        provider: $this->dataStoreName(),
                    )
                );
            }

            if (count($json['response']['docs'] ?? []) < 10) {
                break;
            }

            sleep(15);
        }
    }
}
