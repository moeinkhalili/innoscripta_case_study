<?php

namespace App\Services\ArticlesDataStore;

use App\Services\ArticlesDataStore\Handlers\Guardian;
use App\Services\ArticlesDataStore\Handlers\NewsApi;
use App\Services\ArticlesDataStore\Handlers\NewyorkTimes;

class ArticlesHandlers
{
    public array $handlers = [
        NewyorkTimes::class,
        NewsApi::class,
        Guardian::class,
    ];
}
