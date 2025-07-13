<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    protected $fillable = ['profile_id', 'image_path', 'caption'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
