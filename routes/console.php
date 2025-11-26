<?php

use App\Console\Commands\FetchArticles;
use Illuminate\Support\Facades\Schedule;

// This should run with cron
Schedule::command(FetchArticles::class)
    ->everySixHours()
    ->runInBackground();
