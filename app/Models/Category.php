<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property HasMany $articles
 * @property HasManyThrough $preferredUsers
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function preferredUsers(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, UserPreference::class, 'preferred_category_id', 'id', 'id', 'user_id');
    }
}
