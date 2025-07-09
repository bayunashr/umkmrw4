<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'description', 'address', 'latitude', 'longitude', 'phone', 'logo_path', 'cover_path'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
