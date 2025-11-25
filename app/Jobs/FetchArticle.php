<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class FetchArticle implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private readonly string $provider) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app($this->provider)->fetchArticles();
    }
}
