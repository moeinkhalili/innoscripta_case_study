<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticle;
use App\Services\ArticlesDataStore\ArticlesHandlers;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class FetchArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all the articles from source';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Fetching articles from source...');
        foreach (app(ArticlesHandlers::class)->handlers as $handler) {
            dispatch_sync(new FetchArticle(app($handler)));
        }
        Cache::tags(['preferred-articles'])->flush();
        $this->info('Finished fetching articles from source.');
    }
}
