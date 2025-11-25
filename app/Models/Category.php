<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property HasMany $preferredUsers
 */
class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    public function preferredUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
