<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['profile_id', 'name', 'description', 'price', 'image_path'];
}
