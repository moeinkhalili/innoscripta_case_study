<?php

namespace Feature\Console;

use App\Jobs\FetchArticle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchArticles extends TestCase
{
    use RefreshDatabase;

    public function test_job_dispatch_when_command_runs(): void
    {
        Queue::fake();
        $this->artisan('app:fetch-articles');
        Queue::assertPushed(FetchArticle::class);
    }

    public function test_store_fake_data(): void
    {
        // Fake new york times data
        Http::fake([
            'https://api.nytimes.com/*' => Http::response([
                'response' => [
                    'docs' => [
                        [
                            'headline' => ['main' => 'Fake Article 1'],
                            'byline' => ['original' => 'By John Doe'],
                            'pub_date' => Carbon::yesterday()->toIso8601String(),
                            'abstract' => 'Fake abstract 1',
                            'section_name' => 'Tech',
                            'urlToImage' => 'https://example.com/img1.jpg',
                            'uri' => '/fake-uri-1',
                        ],
                    ],
                ],
            ]),
        ]);

        // Fake news api data
        Http::fake([
            'https://newsapi.org/*' => Http::response([
                'articles' => [
                    [
                        'title' => 'Fake News 1',
                        'description' => 'Description 1',
                        'publishedAt' => now()->toIso8601String(),
                        'urlToImage' => 'https://example.com/img1.jpg',
                        'url' => 'https://example.com/news1',
                        'author' => 'John Doe',
                        'source' => ['name' => 'Bild'],
                    ],
                ],
            ]),
        ]);

        // Fake guardian data
        Http::fake([
            'https://content.guardianapis.com/*' => Http::response([
                'response' => [
                    'results' => [
                        [
                            'webTitle' => 'Fake Guardian Article 1',
                            'webPublicationDate' => Carbon::tomorrow()->toIso8601String(),
                            'sectionName' => 'World',
                            'webUrl' => 'https://example.com/guardian1',
                            'fields' => [
                                'body' => '<p>Fake HTML content 1</p>',
                                'thumbnail' => 'https://example.com/img1.jpg',
                                'byline' => 'John Guardian',
                            ],
                        ],
                    ],
                ],
            ]),
        ]);

        $this->artisan('app:fetch-articles');

        $this->assertDatabaseCount('articles', 3);
    }
}
