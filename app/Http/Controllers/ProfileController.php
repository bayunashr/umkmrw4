<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $umkm = auth()->user()->profile;
        $productCount = Product::where('profile_id', $umkm->id)->count();
        $galleryCount = Gallery::where('profile_id', $umkm->id)->count();
        return view('profile.index', compact('umkm', 'productCount', 'galleryCount'));
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
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        $id = Profile::with('user')->where('slug', $slug)->firstOrFail()->id;
        $umkm = Profile::with('user')->findOrFail($id);
        return view('profile.edit', compact('umkm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $slug)
    {
        // Ambil profile milik user yang sedang login
        $profile = Profile::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->with('user', 'socialMedia')
            ->firstOrFail();

        $user = $profile->user;

        $validated = $request->validate([
            'owner' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:profiles,name,' . $profile->id,
            'username' => 'required|string|max:100|unique:users,username,' . $user->id . '|alpha_dash',
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:500',
            'rt' => 'nullable|integer|min:1|max:999',
            'rw' => 'nullable|integer|min:1|max:999',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'social_media' => 'nullable|array',
            'social_media.*.platform' => 'required_with:social_media.*.url|in:instagram,facebook,twitter,tiktok,whatsapp,youtube,linkedin',
            'social_media.*.url' => 'required_with:social_media.*.platform|url',
        ], [
            // Custom error messages
            'owner.required' => 'Nama pemilik wajib diisi.',
            'name.required' => 'Nama UMKM wajib diisi.',
            'name.unique' => 'Nama UMKM sudah digunakan.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh mengandung huruf, angka, dash, dan underscore.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon hanya boleh mengandung angka.',
            'phone.max' => 'Nomor telepon tidak boleh lebih dari 20 karakter.',
            'latitude.required' => 'Latitude wajib diisi.',
            'latitude.between' => 'Latitude harus berada antara -90 dan 90.',
            'longitude.required' => 'Longitude wajib diisi.',
            'longitude.between' => 'Longitude harus berada antara -180 dan 180.',
            'social_media.*.platform.required_with' => 'Platform sosial media wajib dipilih jika URL diisi.',
            'social_media.*.platform.in' => 'Platform sosial media tidak valid.',
            'social_media.*.url.required_with' => 'URL sosial media wajib diisi jika platform dipilih.',
            'social_media.*.url.url' => 'Format URL sosial media tidak valid.',
            'description.max' => 'Deskripsi tidak boleh lebih dari 1000 karakter.',
            'address.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
        ]);

        DB::beginTransaction();

        try {
            // Generate slug baru jika nama berubah
            $newSlug = $profile->name !== $validated['name']
                ? generate_unique_slug('profiles', 'slug', $validated['name'], $profile->id)
                : $profile->slug;

            // Update User
            $user->update([
                'name' => $validated['owner'],
                'username' => $validated['username'],
            ]);

            // Update Profile
            $profile->update([
                'name' => $validated['name'],
                'slug' => $newSlug,
                'phone' => $validated['phone'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // Update Social Media
            $profile->socialMedia()->delete();
            if (!empty($validated['social_media'])) {
                $socialMediaData = [];
                foreach ($validated['social_media'] as $social) {
                    // Skip jika platform atau URL kosong
                    if (empty($social['platform']) || empty($social['url'])) {
                        continue;
                    }

                    $socialMediaData[] = [
                        'profile_id' => $profile->id,
                        'platform' => $social['platform'],
                        'url' => $social['url'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                if (!empty($socialMediaData)) {
                    SocialMedia::insert($socialMediaData);
                }
            }

            DB::commit();

            return redirect()->route('umkm.profile')->with('success', 'Profil UMKM berhasil diperbarui!');

        } catch (\Throwable $e) {
            DB::rollBack();

            Log::error('Error updating UMKM profile: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'profile_id' => $profile->id,
                'request_data' => $request->all()
            ]);

            return back()->withInput()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        //
    }

    public function storeLogo(Request $request)
    {
        $umkm = auth()->user()->profile;

        if (!$umkm) {
            return redirect()->back()->with('error', 'Data UMKM tidak ditemukan.');
        }

        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        if ($umkm->logo_path) {
            return redirect()->back()->with('error', 'Logo sudah ada. Gunakan edit untuk mengganti.');
        }

        $path = $request->file('logo')->store('logos', 'public');
        $umkm->update(['logo_path' => $path]);

        return redirect()->back()->with('success', 'Logo berhasil ditambahkan.');
    }

    public function updateLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        $umkm = auth()->user()->profile;

        if ($umkm->logo_path) {
            Storage::disk('public')->delete($umkm->logo_path);
        }

        $path = $request->file('logo')->store('logos', 'public');
        $umkm->update(['logo_path' => $path]);

        return redirect()->back()->with('success', 'Logo berhasil diperbarui.');
    }

    public function destroyLogo()
    {
        $umkm = auth()->user()->profile;

        if ($umkm->logo_path) {
            Storage::disk('public')->delete($umkm->logo_path);
            $umkm->update(['logo_path' => null]);
        }

        return redirect()->back()->with('success', 'Logo berhasil dihapus.');
    }

    /**
     * Store cover image
     */
    public function storeCover(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $umkm = auth()->user()->profile;

        if (!$umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        try {
            if ($request->hasFile('cover')) {
                // Delete old cover if exists
                if ($umkm->cover_path && Storage::disk('public')->exists($umkm->cover_path)) {
                    Storage::disk('public')->delete($umkm->cover_path);
                }

                // Store new cover
                $path = $request->file('cover')->store('umkm/covers', 'public');

                $umkm->update([
                    'cover_path' => $path
                ]);

                return redirect()->back()->with('success', 'Cover berhasil ditambahkan!');
            }

            return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengupload cover: ' . $e->getMessage());
        }
    }

    /**
     * Update cover image
     */
    public function updateCover(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
        ]);

        $umkm = auth()->user()->profile;

        if (!$umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        try {
            if ($request->hasFile('cover')) {
                // Delete old cover if exists
                if ($umkm->cover_path && Storage::disk('public')->exists($umkm->cover_path)) {
                    Storage::disk('public')->delete($umkm->cover_path);
                }

                // Store new cover
                $path = $request->file('cover')->store('umkm/covers', 'public');

                $umkm->update([
                    'cover_path' => $path
                ]);

                return redirect()->back()->with('success', 'Cover berhasil diperbarui!');
            }

            return redirect()->back()->with('error', 'Tidak ada file yang diupload.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui cover: ' . $e->getMessage());
        }
    }

    /**
     * Delete cover image
     */
    public function destroyCover()
    {
        $umkm = auth()->user()->profile;

        if (!$umkm) {
            return redirect()->back()->with('error', 'UMKM tidak ditemukan.');
        }

        try {
            if ($umkm->cover_path && Storage::disk('public')->exists($umkm->cover_path)) {
                Storage::disk('public')->delete($umkm->cover_path);
            }

            $umkm->update([
                'cover_path' => null
            ]);

            return redirect()->back()->with('success', 'Cover berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus cover: ' . $e->getMessage());
        }
    }

    /**
     * Show change password form
     */
    public function showChangePasswordForm()
    {
        $umkm = auth()->user()->profile;

        if (!$umkm) {
            return redirect()->route('login')->with('error', 'UMKM tidak ditemukan.');
        }

        return view('password.change', compact('umkm'));
    }

    /**
     * Update password - Simplified for elderly users
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'min:6'], // Hanya minimal 6 karakter
            'new_password_confirmation' => ['required', 'same:new_password'],
        ], [
            'current_password.required' => 'Password lama harus diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',
            'new_password.required' => 'Password baru harus diisi.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
            'new_password_confirmation.required' => 'Konfirmasi password baru harus diisi.',
            'new_password_confirmation.same' => 'Konfirmasi password tidak sesuai dengan password baru.',
        ]);

        $user = auth()->user();

        try {
            // Update password
            $user->update([
                'password' => Hash::make($request->new_password)
            ]);

            return redirect()->back()->with('success', 'Password berhasil diubah!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengubah password. Silakan coba lagi.');
        }
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('password.forgot');
    }
}
