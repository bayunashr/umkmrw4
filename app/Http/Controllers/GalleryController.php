<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
     * Show the form for creating a new gallery
     */
    public function create()
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                return redirect()->route('umkm.profile')
                    ->with('error', 'Silakan lengkapi profile UMKM Anda terlebih dahulu.');
            }

            return view('gallery.create', compact('profile'));

        } catch (\Exception $e) {
            \Log::error('Error in gallery create: ' . $e->getMessage());
            return redirect()
                ->route('umkm.gallery')
                ->with('error', 'Terjadi kesalahan saat mengakses halaman tambah foto.');
        }
    }

    /**
     * Store a newly created gallery
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB
                'caption' => 'nullable|string|max:1000'
            ], [
                'image.required' => 'Foto wajib diupload.',
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 5MB.',
                'caption.max' => 'Keterangan maksimal 1000 karakter.'
            ]);

            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Handle upload gambar
            $file = $request->file('image');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $imagePath = $file->storeAs('galleries', $fileName, 'public');

            // Buat gallery baru
            $gallery = $profile->galleries()->create([
                'image_path' => $imagePath,
                'caption' => $request->caption
            ]);

            return redirect()
                ->route('umkm.gallery')
                ->with('success', 'Foto berhasil ditambahkan ke galeri!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());

        } catch (\Exception $e) {
            \Log::error('Error storing gallery: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan foto: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified gallery
     */
    public function edit($id)
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                return redirect()->route('umkm.profile')
                    ->with('error', 'Profile UMKM tidak ditemukan.');
            }

            // Cari gallery berdasarkan ID dan pastikan milik user yang login
            $gallery = $profile->galleries()->findOrFail($id);

            return view('gallery.edit', compact('gallery', 'profile'));

        } catch (\Exception $e) {
            \Log::error('Error in gallery edit: ' . $e->getMessage());
            return redirect()
                ->route('umkm.gallery')
                ->with('error', 'Foto tidak ditemukan.');
        }
    }

    /**
     * Update the specified gallery
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
                'caption' => 'nullable|string|max:1000'
            ], [
                'image.image' => 'File harus berupa gambar.',
                'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 5MB.',
                'caption.max' => 'Keterangan maksimal 1000 karakter.'
            ]);

            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Cari gallery
            $gallery = $profile->galleries()->findOrFail($id);

            // Jika tidak ada gambar saat ini dan tidak upload gambar baru
            if (!$gallery->image_path && !$request->hasFile('image')) {
                throw new \Exception('Foto wajib diupload.');
            }

            // Simpan path gambar lama
            $oldImagePath = $gallery->image_path;
            $imagePath = $oldImagePath;

            // Handle upload gambar baru
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('galleries', $fileName, 'public');

                // Hapus gambar lama jika ada
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            // Update gallery
            $gallery->update([
                'image_path' => $imagePath,
                'caption' => $request->caption
            ]);

            return redirect()
                ->route('umkm.gallery')
                ->with('success', 'Foto galeri berhasil diperbarui!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());

        } catch (\Exception $e) {
            \Log::error('Error updating gallery: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui foto: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified gallery
     */
    public function destroy($id)
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Cari gallery
            $gallery = $profile->galleries()->findOrFail($id);

            // Hapus gambar dari storage jika ada
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }

            // Hapus gallery dari database
            $gallery->delete();

            return redirect()
                ->route('umkm.gallery')
                ->with('success', 'Foto berhasil dihapus dari galeri!');

        } catch (\Exception $e) {
            \Log::error('Error deleting gallery: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus foto: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified gallery
     */
    public function show($id)
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                return redirect()->route('umkm.profile')
                    ->with('error', 'Profile UMKM tidak ditemukan.');
            }

            // Cari gallery berdasarkan ID dan pastikan milik user yang login
            $gallery = $profile->galleries()->findOrFail($id);

            return view('gallery.show', compact('gallery', 'profile'));

        } catch (\Exception $e) {
            \Log::error('Error in gallery show: ' . $e->getMessage());
            return redirect()
                ->route('umkm.gallery')
                ->with('error', 'Foto tidak ditemukan.');
        }
    }
}
