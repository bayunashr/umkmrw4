<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'description', 'address', 'latitude', 'longitude', 'phone', 'logo_path', 'cover_path', 'is_approved', 'rt', 'rw'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function galleries()
    {
        return $this->hasMany(Gallery::class);
    }

    public function socialMedia()
    {
        return $this->hasMany(SocialMedia::class, 'profile_id');
    }
}
