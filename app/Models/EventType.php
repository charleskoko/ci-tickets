<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $label
 * @property string $description
 */
class EventType extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'description',
    ];
}
