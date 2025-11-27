<?php

namespace App\Jobs;

use App\Services\ArticlesDataStore\Contracts\ArticleHandler;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchArticle implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly ArticleHandler $provider) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->provider->fetchArticles();
    }
}
