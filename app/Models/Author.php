<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\AuthorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property HasMany $preferredUsers
 */
class Author extends Model
{
    /** @use HasFactory<AuthorFactory> */
    use HasFactory;

    protected $fillable = ['name'];

    public function preferredUsers(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
