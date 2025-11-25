<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ArticleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $url
 * @property string $thumbnail
 * @property Carbon $published_at
 * @property string $provider
 * @property ?int $author_id
 * @property ?Author $author
 * @property ?int $category_id
 * @property ?Category $category
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class Article extends Model
{
    /** @use HasFactory<ArticleFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'url',
        'thumbnail',
        'published_at',
        'provider',
        'source_id',
        'author_id',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
