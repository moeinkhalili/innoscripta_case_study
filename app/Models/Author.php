<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property HasMany $articles
 * @property HasManyThrough $preferredUsers
 */
class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function preferredUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserPreference::class, 'preferred_author_id', 'id', 'id', 'user_id');
    }
}
