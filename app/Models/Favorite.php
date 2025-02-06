<?php

namespace App\Models;

use App\Enums\MediaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'media_type',
        'media_id'
    ];

    protected $casts = [
        'media_type' => MediaType::class
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
