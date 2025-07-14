<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
     * Display the specified product
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

            // Cari produk berdasarkan ID dan pastikan milik user yang login
            $product = $profile->products()->findOrFail($id);

            return view('product.show', compact('product', 'profile'));

        } catch (\Exception $e) {
            return redirect()
                ->route('umkm.product')
                ->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Show the form for editing the specified product
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

            // Cari produk berdasarkan ID dan pastikan milik user yang login
            $product = $profile->products()->findOrFail($id);

            return view('product.edit', compact('product', 'profile'));

        } catch (\Exception $e) {
            return redirect()
                ->route('umkm.product')
                ->with('error', 'Produk tidak ditemukan.');
        }
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120', // 5MB
                'remove_current_image' => 'nullable|in:0,1'
            ]);

            // Ambil profile user yang login
            $profile = auth()->user()->profile;

            if (!$profile) {
                throw new \Exception('Profile UMKM tidak ditemukan.');
            }

            // Cari produk
            $product = $profile->products()->findOrFail($id);

            // Simpan path gambar lama
            $oldImagePath = $product->image_path;
            $imagePath = $oldImagePath;

            // Handle remove current image
            if ($request->input('remove_current_image') == '1') {
                if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }
                $imagePath = null;
            }

            // Handle upload gambar baru
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $imagePath = $file->storeAs('products', $fileName, 'public');

                // Hapus gambar lama jika ada dan bukan yang baru diupload
                if ($oldImagePath && $oldImagePath !== $imagePath && Storage::disk('public')->exists($oldImagePath)) {
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
                ->route('umkm.product.show', $product->id)
                ->with('success', 'Produk berhasil diperbarui!');

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
}
