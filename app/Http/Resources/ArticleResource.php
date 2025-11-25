<?php

namespace App\Http\Resources;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Article
 */
class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'url' => $this->url,
            'thumbnail' => $this->thumbnail,
            'published_at' => $this->published_at,
            'provider' => $this->provider,
            'author' => new AuthorResource($this->author),
            'category' => new CategoryResource($this->category),
        ];
    }
}
