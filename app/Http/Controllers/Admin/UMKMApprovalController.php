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
            ->whereHas('user', function ($query) {
                $query->where('role', 1);
            })
            ->get();

        return view('admin.approval.index', compact('pendingUmkm'));
    }

    public function show($id)
    {
        $pendingUmkm = Profile::with('user')->findOrFail($id);
        return view('admin.approval.show', compact('pendingUmkm'));
    }

    public function approve($id)
    {
        $pendingUmkm = Profile::findOrFail($id);
        $pendingUmkm->is_approved = 1;
        $pendingUmkm->save();

        return redirect()->route('admin.approval')->with('success', 'UMKM '.$pendingUmkm->name.' Berhasil Disetujui!');
    }
}
