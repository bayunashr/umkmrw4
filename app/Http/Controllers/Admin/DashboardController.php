<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\SocialMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function showUmkm($slug)
    {
        $id = Profile::with('user')->where('slug', $slug)->firstOrFail()->id;
        $umkm = Profile::with('user')->findOrFail($id);
        $productCount = Product::where('profile_id', $id)->count();
        $galleryCount = Gallery::where('profile_id', $id)->count();
        return view('admin.umkm.show', compact('umkm', 'productCount', 'galleryCount'));
    }

    public function createUmkm()
    {
        return view('admin.umkm.create');
    }

    public function storeUmkm(Request $request)
    {
        $validated = $request->validate([
            'owner' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:profiles,name',
            'username' => 'required|string|max:100|unique:users,username|alpha_dash',
            'phone' => 'required|max:20',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'rt' => 'nullable|integer|min:1|max:999',
            'rw' => 'nullable|integer|min:1|max:999',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'password' => 'required|string|min:6|confirmed',
            'social_media' => 'nullable|array',
            'social_media.*.platform' => 'required_with:social_media.*.url|in:instagram,facebook,twitter,tiktok,whatsapp,youtube,linkedin',
            'social_media.*.url' => 'required_with:social_media.*.platform|url',
        ]);

        $user = User::create([
            'name' => $validated['owner'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'role' => 1,
        ]);

        $profile = Profile::create([
            'user_id' => $user->id,
            'owner_name' => $validated['owner'],
            'name' => $validated['name'],
            'slug' => generate_unique_slug('profiles', 'slug', $validated['name']),
            'phone' => $validated['phone'],
            'description' => $validated['description'],
            'address' => $validated['address'],
            'rt' => $validated['rt'],
            'rw' => $validated['rw'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'is_approved' => 1,
        ]);

        if (!empty($validated['social_media'])) {
            foreach ($validated['social_media'] as $social) {
                SocialMedia::create([
                    'profile_id' => $profile->id,
                    'platform' => $social['platform'],
                    'url' => $social['url'],
                ]);
            }
        }

        return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil ditambahkan.');
    }

    public function editUmkm($slug)
    {
        $id = Profile::with('user')->where('slug', $slug)->firstOrFail()->id;
        $umkm = Profile::with('user')->findOrFail($id);
        return view('admin.umkm.edit', compact('umkm'));
    }

    public function updateUmkm(Request $request, $slug)
    {
        $profile = Profile::where('slug', $slug)->with('user', 'socialMedia')->firstOrFail();
        $user = $profile->user;

        $validated = $request->validate([
            'owner' => 'required|string|max:255',
            'name' => 'required|string|max:255|unique:profiles,name,' . $profile->id,
            'username' => 'required|string|max:100|unique:users,username,' . $user->id . '|alpha_dash',
            'phone' => ['required', 'regex:/^[0-9]+$/', 'max:20'],
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'rt' => 'nullable|integer|min:1|max:999',
            'rw' => 'nullable|integer|min:1|max:999',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'social_media' => 'nullable|array',
            'social_media.*.platform' => 'required_with:social_media.*.url|in:instagram,facebook,twitter,tiktok,whatsapp,youtube,linkedin',
            'social_media.*.url' => 'required_with:social_media.*.platform|url',
        ]);

        DB::beginTransaction();

        try {
            // Update User
            $user->update([
                'name' => $validated['owner'],
                'username' => $validated['username'],
            ]);

            // Update Profile
            $profile->update([
                'owner_name' => $validated['owner'],
                'name' => $validated['name'],
                'slug' => generate_unique_slug('profiles', 'slug', $validated['name'], $profile->id),
                'phone' => $validated['phone'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            // Hapus dan insert ulang Social Media
            $profile->socialMedia()->delete();
            if (!empty($validated['social_media'])) {
                foreach ($validated['social_media'] as $social) {
                    SocialMedia::create([
                        'profile_id' => $profile->id,
                        'platform' => $social['platform'],
                        'url' => $social['url'],
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.umkm.index')->with('success', 'UMKM berhasil diperbarui.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }
}
