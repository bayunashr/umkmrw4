<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class UMKMApprovalController extends Controller
{
    public function index()
    {
        $pendingUmkm = Profile::with('user')
            ->where('profiles.is_approved', 0)
            ->get();

        return view('admin.approval', compact('pendingUmkm'));
    }
}
