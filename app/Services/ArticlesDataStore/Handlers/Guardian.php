<?php

namespace App\Services\ArticlesDataStore\Handlers;

use App\Repositories\ArticleRepository;
use App\Services\ArticlesDataStore\Concerns\ArticleDataStoreTrait;
use App\Services\ArticlesDataStore\Contracts\ArticleHandler;
use App\Services\ArticlesDataStore\Dto\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Soundasleep\Html2Text;

class Guardian implements ArticleHandler
{
    use ArticleDataStoreTrait;

    public string $url = 'https://content.guardianapis.com/';

    public function __construct(protected ArticleRepository $articleRepository) {}

    public function dataStoreName(): string
    {
        return 'guardian';
    }

    public function fetchArticles(): void
    {
        for ($page = 1; $page <= 5; $page++) {
            $response = Http::get("$this->url/search", [
                'api-key' => config('articles.providers.guardian.api_key'),
                'from-date' => $this->getFromDate()->format('Y-m-d'),
                'show-references' => 'author',
                'show-section' => 'true',
                'page-size' => 20,
                'page' => $page++,
                'show-fields' => 'headline,thumbnail,body',
            ])->throw();

            $json = $response->json();

            foreach ($json['response']['results'] ?? [] as $article) {
                $this->articleRepository->updateOrCreate(
                    new Article(
                        title: $article['webTitle'],
                        content: Html2Text::convert($article['fields']['body'], [
                            'ignore_errors' => true,
                            'drop_links' => true,
                        ]), // convert HTML to normal text
                        publishedAt: Carbon::parse($article['webPublicationDate']),
                        category: $article['sectionName'],
                        thumbnail: $article['fields']['thumbnail'] ?? null,
                        url: $article['webUrl'],
                        author: $article['fields']['byline'] ?? 'The Guardian',
                        provider: $this->dataStoreName(),
                    )
                );
            }

            if (count($json['response']['results'] ?? []) < 20) {
                break;
            }

        }
    }
}
