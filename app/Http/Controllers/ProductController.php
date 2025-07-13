<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = auth()->user()->profile->products;
        return view('product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $profile = auth()->user()->profile;
        return view('product.create', compact('profile'));
    }

    /**
     * Simpan produk baru
     */
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120' // 5MB
            ]);

            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Handle upload gambar
            $imagePath = null;
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName, 'public');
            }

            // Buat produk baru
            $product = $profile->products()->create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $imagePath
            ]);

            return redirect()
                ->route('umkm.product')
                ->with('success', 'Produk berhasil ditambahkan');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Update produk
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120' // 5MB
            ]);

            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Cari produk
            $product = $profile->products()->findOrFail($id);

            // Simpan path gambar lama untuk dihapus jika ada perubahan
            $oldImagePath = $product->image_path;
            $imagePath = $oldImagePath;

            // Handle upload gambar baru
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName, 'public');

                // Hapus gambar lama jika ada
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            // Update produk
            $product->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'image_path' => $imagePath
            ]);

            return redirect()
                ->route('umkm.product')
                ->with('success', 'Produk berhasil diperbarui');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($e->errors());

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Hapus produk
     */
    public function destroy($id)
    {
        try {
            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Cari produk
            $product = $profile->products()->findOrFail($id);

            // Hapus gambar jika ada
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            // Hapus produk
            $product->delete();

            return redirect()
                ->route('umkm.product')
                ->with('success', 'Produk berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat menghapus produk: ' . $e->getMessage());
        }
    }

    /**
     * Upload gambar produk via Dropzone
     */
    public function uploadImage(Request $request, $slug)
    {
        try {
            // Validasi file
            $request->validate([
                'file' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB
            ]);

            // Cari profile berdasarkan slug
            $profile = Profile::where('slug', $slug)->firstOrFail();

            // Generate nama file yang unik
            $file = $request->file('file');
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage/app/public/products
            $path = $file->storeAs('products', $fileName, 'public');

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil diupload',
                'path' => $path,
                'url' => Storage::url($path)
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak valid. Pastikan file berformat JPG, PNG, atau JPEG dan ukuran maksimal 5MB.',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat upload: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus gambar produk
     */
    public function deleteImage(Request $request, $slug)
    {
        try {
            $request->validate([
                'path' => 'required|string'
            ]);

            $path = $request->input('path');

            // Hapus file dari storage
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return response()->json([
                'success' => true,
                'message' => 'Gambar berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            \Log::error('Delete image error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat hapus gambar'
            ], 500);
        }
    }
}
