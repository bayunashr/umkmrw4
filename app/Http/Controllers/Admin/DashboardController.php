<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('layouts.admin');
    }

    public function indexUmkm()
    {
        $allUmkm = Profile::with('user')
            ->where('profiles.is_approved', 1)
            ->whereHas('user', function ($query) {
                $query->where('role', 1);
            })
            ->get();
        return view('admin.umkm.index', compact('allUmkm'));
    }
}
