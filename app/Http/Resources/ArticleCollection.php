<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($article) {
                /**
                 * @var Article $article
                 */
                return [
                    'id' => $article->id,
                    'title' => $article->title,
                    'body' => $article->body,
                    'url' => $article->url,
                    'thumbnail' => $article->thumbnail,
                    'published_at' => $article->published_at,
                    'provider' => $article->provider,
                    'author_id' => $article->author_id,
                    'category_id' => $article->category_id,
                ];
            }),
        ];
    }
}
