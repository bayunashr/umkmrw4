<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

if (!function_exists('generate_unique_slug')) {
    function generate_unique_slug(string $table, string $column, string $value): string
    {
        $slug = Str::slug($value);
        $original = $slug;
        $i = 1;

        while (DB::table($table)->where($column, $slug)->exists()) {
            $slug = $original . '-' . $i++;
        }

        return $slug;
    }
}
