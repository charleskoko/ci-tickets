<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $name
 * @property string $mobile
 * @property string $website
 * @property string $localisation
 * @property boolean $is_active
 * @property User $owner
 * @property int $user_id
 */
class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'mobile',
        'website',
        'localisation',
        'is_active'
    ];

    public function isOwner(User $user): bool
    {
       return $this->user_id == $user->id;
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
