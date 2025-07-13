<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['profile_id', 'name', 'description', 'price', 'image_path'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
