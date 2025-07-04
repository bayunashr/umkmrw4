<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['user_id', 'name', 'slug', 'owner_name', 'description', 'address', 'latitude', 'longitude', 'phone', 'logo_path', 'cover_path'];
}
