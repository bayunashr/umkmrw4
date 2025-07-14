<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                return redirect()->route('umkm.profile')
                    ->with('error', 'Silakan lengkapi profile UMKM Anda terlebih dahulu.');
            }

            // Ambil semua galeri milik profile ini, urutkan berdasarkan tanggal terbaru
            $galleries = $profile->galleries()
                ->latest()
                ->get();

            return view('gallery.index', compact('galleries', 'profile'));

        } catch (\Exception $e) {
            \Log::error('Error in gallery index: ' . $e->getMessage());
            return redirect()
                ->route('umkm.dashboard')
                ->with('error', 'Terjadi kesalahan saat mengakses galeri.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Gallery $gallery)
    {
        //
    }
}
