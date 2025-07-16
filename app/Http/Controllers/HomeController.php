<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua UMKM yang sudah approved dengan koordinat yang valid
        $umkms = Profile::where('is_approved', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0)
            ->whereHas('user', function ($query) {
                $query->where('role', 1);
            })
            ->with(['user', 'products' => function($query) {
                $query->take(3); // Ambil 3 produk terbaru
            }])
            ->select('id', 'user_id', 'name', 'slug', 'description', 'latitude', 'longitude', 'address', 'phone', 'logo_path', 'cover_path', 'created_at')
            ->get();

        // Statistik untuk dashboard
        $stats = [
            'total_umkm' => Profile::where('is_approved', 1)->count(),
            'total_products' => DB::table('products')
                ->join('profiles', 'products.profile_id', '=', 'profiles.id')
                ->where('profiles.is_approved', 1)
                ->count(),
            'new_umkm_today' => Profile::where('is_approved', 1)
                ->whereDate('approved_at', today())
                ->count(),
            'areas_covered' => Profile::where('is_approved', 1)
                ->whereNotNull('address')
                ->get()
                ->map(function($profile) {
                    // Extract area from address (last part after comma)
                    $addressParts = explode(',', $profile->address);
                    return trim(end($addressParts));
                })
                ->filter()
                ->unique()
                ->count()
        ];

        // Kategori UMKM berdasarkan kata kunci dalam deskripsi
        $categories = $this->getCategoriesFromDescription($umkms);

        return view('home.map', compact('umkms', 'stats', 'categories'));
    }

    public function searchUmkm(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');

        // Validate input
        if (!$query || strlen(trim($query)) < 1) {
            return response()->json([]);
        }

        $umkmsQuery = Profile::where('is_approved', 1)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->where('latitude', '!=', 0)
            ->where('longitude', '!=', 0);

        // Search in multiple fields
        if ($query) {
            $umkmsQuery->where(function($q) use ($query) {
                $q->where('name', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%')
                    ->orWhere('address', 'LIKE', '%' . $query . '%');
            });
        }

        // Category filter
        if ($category && $category !== 'null') {
            if ($category === 'lainnya') {
                // Filter for uncategorized UMKMs
                $keywords = ['makanan', 'minuman', 'fashion', 'kerajinan', 'jasa', 'elektronik', 'kecantikan', 'otomotif', 'pertanian', 'teknologi'];
                $umkmsQuery->where(function($q) use ($keywords) {
                    foreach ($keywords as $keyword) {
                        $q->where('description', 'NOT LIKE', '%' . $keyword . '%');
                    }
                });
            } else {
                $umkmsQuery->where('description', 'LIKE', '%' . $category . '%');
            }
        }

        $umkms = $umkmsQuery->select('id', 'name', 'slug', 'description', 'latitude', 'longitude', 'address', 'phone', 'logo_path', 'created_at')
            ->limit(10) // Limit results for performance
            ->get();

        return response()->json($umkms);
    }

    private function getCategoriesFromDescription($umkms)
    {
        $keywords = ['makanan', 'minuman', 'fashion', 'kerajinan', 'jasa', 'elektronik', 'kecantikan', 'otomotif', 'pertanian', 'teknologi'];
        $categories = [];
        $categorizedIds = [];

        foreach ($keywords as $keyword) {
            $filteredUmkms = $umkms->filter(function($umkm) use ($keyword) {
                return stripos($umkm->description, $keyword) !== false;
            });

            $count = $filteredUmkms->count();
            if ($count > 0) {
                $categories[] = [
                    'name' => ucfirst($keyword),
                    'count' => $count,
                    'keyword' => $keyword
                ];

                // Collect IDs of categorized UMKMs
                $categorizedIds = array_merge($categorizedIds, $filteredUmkms->pluck('id')->toArray());
            }
        }

        // Add "Lainnya" category for uncategorized UMKMs
        $uncategorizedUmkms = $umkms->filter(function($umkm) use ($categorizedIds) {
            return !in_array($umkm->id, $categorizedIds);
        });

        $otherCount = $uncategorizedUmkms->count();
        if ($otherCount > 0) {
            $categories[] = [
                'name' => 'Lainnya',
                'count' => $otherCount,
                'keyword' => 'lainnya'
            ];
        }

        return collect($categories)->sortByDesc('count')->values()->all();
    }

    /**
     * Menampilkan landing page profile berdasarkan slug
     * Ini adalah halaman yang menggunakan template yang sudah dibuat
     */
    public function show($slug)
    {
        try {
            // Ambil profile berdasarkan slug dengan semua relasi
            $profile = Profile::with([
                'products' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'galleries' => function($query) {
                    $query->orderBy('created_at', 'desc');
                },
                'socialMedia' => function($query) {
                    $query->orderBy('platform');
                },
                'user'
            ])
                ->where('slug', $slug)
                ->where('is_approved', 1)
                ->firstOrFail();

            // Update view count (optional - untuk statistik)
            // $this->incrementViewCount($profile);

            return view('home.profile', compact('profile'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Profile tidak ditemukan atau belum diapprove
            abort(404, 'Profil tidak ditemukan atau belum disetujui.');
        } catch (\Exception $e) {
            // Log error untuk debugging
            \Log::error('Error in HomeController@show: ' . $e->getMessage());

            abort(500, 'Terjadi kesalahan dalam memuat profil.');
        }
    }

    public function showForgotPasswordForm()
    {
        return view('password.forgot');
    }
}
