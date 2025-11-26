<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\UserPreferenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property User $user
 * @property ?int $preferred_author_id
 * @property ?Author $preferredAuthor
 * @property ?int $preferred_category_id
 * @property ?Category $preferredCategory
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 */
class UserPreference extends Model
{
    /** @use HasFactory<UserPreferenceFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'preferred_author_id',
        'preferred_category_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function preferredAuthor(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function preferredCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
