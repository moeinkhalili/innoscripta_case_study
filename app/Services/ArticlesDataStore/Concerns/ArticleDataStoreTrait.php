<?php

namespace App\Services\ArticlesDataStore\Concerns;

use App\Models\Article;
use Carbon\Carbon;

trait ArticleDataStoreTrait
{
    public function getFromDate(): Carbon
    {
        $from = Carbon::now()->subDay()->startOfDay();
        if ($lastArticle = Article::query()->where('provider', $this->dataStoreName())->orderBy('id', 'DESC')->first()) {
            return $lastArticle->published_at;
        }

        return $from;
    }
}
