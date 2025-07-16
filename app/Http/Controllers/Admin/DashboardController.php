<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Profile;
use App\Models\SocialMedia;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        // Get basic counts
        $totalUmkm = Profile::count();
        $totalProducts = Product::count();
        $totalGalleries = Gallery::count();
        $totalUsers = User::where('role', 'umkm')->count();

        // Calculate this month's data
        $thisMonth = Carbon::now();
        $thisMonthUmkm = Profile::whereYear('created_at', $thisMonth->year)
            ->whereMonth('created_at', $thisMonth->month)
            ->count();

        $thisMonthProducts = Product::whereYear('created_at', $thisMonth->year)
            ->whereMonth('created_at', $thisMonth->month)
            ->count();

        $thisMonthGalleries = Gallery::whereYear('created_at', $thisMonth->year)
            ->whereMonth('created_at', $thisMonth->month)
            ->count();

        // Calculate growth statistics
        $growthStats = $this->calculateGrowthStats();

        // Get monthly statistics for charts
        $monthlyStats = $this->getMonthlyStatistics();

        // Get top performing UMKM
        $topUmkm = $this->getTopPerformingUmkm();

        // Get recent activities
        $recentActivities = $this->getRecentActivities();

        // Calculate platform health metrics
        $avgProductsPerUmkm = $totalUmkm > 0 ? round($totalProducts / $totalUmkm, 1) : 0;
        $avgGalleriesPerUmkm = $totalUmkm > 0 ? round($totalGalleries / $totalUmkm, 1) : 0;

        // Calculate percentage of UMKM with complete profiles
        $umkmWithCompleteProfile = $this->calculateCompleteProfilePercentage();


        return view('admin.dashboard.index', compact(
            'totalUmkm',
            'totalProducts',
            'totalGalleries',
            'totalUsers',
            'thisMonthUmkm',
            'thisMonthProducts',
            'thisMonthGalleries',
            'growthStats',
            'monthlyStats',
            'topUmkm',
            'recentActivities',
            'avgProductsPerUmkm',
            'avgGalleriesPerUmkm',
            'umkmWithCompleteProfile',
        ));
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

    /**
     * Calculate growth statistics compared to last month
     */
    private function calculateGrowthStats()
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // UMKM growth
        $currentMonthUmkm = Profile::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthUmkm = Profile::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $umkmGrowth = $this->calculatePercentageGrowth($lastMonthUmkm, $currentMonthUmkm);

        // Products growth
        $currentMonthProducts = Product::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthProducts = Product::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $productsGrowth = $this->calculatePercentageGrowth($lastMonthProducts, $currentMonthProducts);

        // Galleries growth
        $currentMonthGalleries = Gallery::whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthGalleries = Gallery::whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $galleriesGrowth = $this->calculatePercentageGrowth($lastMonthGalleries, $currentMonthGalleries);

        // Users growth
        $currentMonthUsers = User::where('role', 'umkm')
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthUsers = User::where('role', 'umkm')
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $usersGrowth = $this->calculatePercentageGrowth($lastMonthUsers, $currentMonthUsers);

        return [
            'umkm' => $umkmGrowth,
            'products' => $productsGrowth,
            'galleries' => $galleriesGrowth,
            'users' => $usersGrowth
        ];
    }

    /**
     * Get monthly statistics for the last 6 months
     */
    private function getMonthlyStatistics()
    {
        $months = [];
        $umkmData = [];
        $productData = [];
        $galleryData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            // Count UMKM registered in this month
            $umkmCount = Profile::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Count products created in this month
            $productCount = Product::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Count galleries created in this month
            $galleryCount = Gallery::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $umkmData[] = $umkmCount;
            $productData[] = $productCount;
            $galleryData[] = $galleryCount;
        }

        return [
            'months' => $months,
            'umkm' => $umkmData,
            'products' => $productData,
            'galleries' => $galleryData
        ];
    }

    /**
     * Get top performing UMKM based on products count
     */
    private function getTopPerformingUmkm()
    {
        return Profile::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(10)
            ->get();
    }

    /**
     * Get recent activities across the platform
     */
    private function getRecentActivities()
    {
        $activities = collect();

        // Recent UMKM registrations
        $recentUmkm = Profile::latest()
            ->limit(3)
            ->get()
            ->map(function($umkm) {
                return [
                    'type' => 'umkm',
                    'title' => 'UMKM Baru Terdaftar',
                    'description' => $umkm->name,
                    'time' => $umkm->created_at->diffForHumans(),
                    'created_at' => $umkm->created_at
                ];
            });

        // Recent products
        $recentProducts = Product::with('Profile')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($product) {
                return [
                    'type' => 'product',
                    'title' => 'Produk Baru Ditambahkan',
                    'description' => $product->name . ' oleh ' . $product->Profile->name,
                    'time' => $product->created_at->diffForHumans(),
                    'created_at' => $product->created_at
                ];
            });

        // Recent galleries
        $recentGalleries = Gallery::with('Profile')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($gallery) {
                return [
                    'type' => 'gallery',
                    'title' => 'Foto Baru Diupload',
                    'description' => ($gallery->caption ?: 'Foto galeri') . ' oleh ' . $gallery->Profile->name,
                    'time' => $gallery->created_at->diffForHumans(),
                    'created_at' => $gallery->created_at
                ];
            });

        // Merge and sort by created_at
        $activities = $activities->merge($recentUmkm)
            ->merge($recentProducts)
            ->merge($recentGalleries)
            ->sortByDesc('created_at')
            ->take(10);

        return $activities;
    }

    /**
     * Calculate percentage of UMKM with complete profiles
     */
    private function calculateCompleteProfilePercentage()
    {
        $totalUmkm = Profile::count();

        if ($totalUmkm == 0) {
            return 0;
        }

        // Count UMKM with complete essential fields
        $completeProfiles = Profile::whereNotNull('name')
            ->whereNotNull('description')
            ->whereNotNull('address')
            ->whereNotNull('phone')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->count();

        return round(($completeProfiles / $totalUmkm) * 100);
    }

    /**
     * Calculate percentage of active users (logged in last 30 days)
     */


    /**
     * Calculate percentage growth between two values
     */
    private function calculatePercentageGrowth($oldValue, $newValue)
    {
        if ($oldValue == 0) {
            return $newValue > 0 ? 100 : 0;
        }

        return round((($newValue - $oldValue) / $oldValue) * 100);
    }

    /**
     * Get platform statistics for API/AJAX calls
     */
    public function getStatistics()
    {
        $stats = [
            'overview' => [
                'total_umkm' => Profile::count(),
                'total_products' => Product::count(),
                'total_galleries' => Gallery::count(),
                'total_users' => User::where('role', 'umkm')->count(),
            ],
            'this_month' => [
                'new_umkm' => Profile::whereMonth('created_at', Carbon::now()->month)->count(),
                'new_products' => Product::whereMonth('created_at', Carbon::now()->month)->count(),
                'new_galleries' => Gallery::whereMonth('created_at', Carbon::now()->month)->count(),
                'new_users' => User::where('role', 'umkm')->whereMonth('created_at', Carbon::now()->month)->count(),
            ],
            'growth_rates' => $this->calculateGrowthStats(),
            'top_umkm' => $this->getTopPerformingUmkm()->take(5),
            'platform_health' => [
                'avg_products_per_umkm' => $this->calculateAverageProductsPerUmkm(),
                'avg_galleries_per_umkm' => $this->calculateAverageGalleriesPerUmkm(),
                'complete_profile_percentage' => $this->calculateCompleteProfilePercentage(),
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Get regional statistics
     */
    public function getRegionalStatistics()
    {
        // Group UMKM by city/region (from address field)
        $regionalStats = Profile::selectRaw('
                CASE
                    WHEN address LIKE "%jakarta%" THEN "Jakarta"
                    WHEN address LIKE "%surabaya%" THEN "Surabaya"
                    WHEN address LIKE "%bandung%" THEN "Bandung"
                    WHEN address LIKE "%medan%" THEN "Medan"
                    WHEN address LIKE "%semarang%" THEN "Semarang"
                    WHEN address LIKE "%yogyakarta%" OR address LIKE "%jogja%" THEN "Yogyakarta"
                    WHEN address LIKE "%malang%" THEN "Malang"
                    WHEN address LIKE "%solo%" THEN "Solo"
                    ELSE "Lainnya"
                END as region,
                COUNT(*) as umkm_count
            ')
            ->groupBy('region')
            ->orderBy('umkm_count', 'desc')
            ->get();

        return response()->json($regionalStats);
    }

    /**
     * Get industry/category statistics
     */
    public function getCategoryStatistics()
    {
        // Analyze categories based on UMKM descriptions or product categories
        $categoryStats = Profile::selectRaw('
                CASE
                    WHEN description LIKE "%makanan%" OR description LIKE "%kuliner%" OR description LIKE "%restoran%" OR description LIKE "%warung%" THEN "Kuliner"
                    WHEN description LIKE "%fashion%" OR description LIKE "%pakaian%" OR description LIKE "%baju%" OR description LIKE "%sepatu%" THEN "Fashion"
                    WHEN description LIKE "%elektronik%" OR description LIKE "%gadget%" OR description LIKE "%komputer%" THEN "Elektronik"
                    WHEN description LIKE "%kerajinan%" OR description LIKE "%handmade%" OR description LIKE "%craft%" THEN "Kerajinan"
                    WHEN description LIKE "%kecantikan%" OR description LIKE "%kosmetik%" OR description LIKE "%skincare%" THEN "Kecantikan"
                    WHEN description LIKE "%otomotif%" OR description LIKE "%motor%" OR description LIKE "%mobil%" THEN "Otomotif"
                    WHEN description LIKE "%pertanian%" OR description LIKE "%organik%" OR description LIKE "%sayur%" THEN "Pertanian"
                    ELSE "Lainnya"
                END as category,
                COUNT(*) as umkm_count
            ')
            ->groupBy('category')
            ->orderBy('umkm_count', 'desc')
            ->get();

        return response()->json($categoryStats);
    }

    /**
     * Export platform data
     */
    public function exportData(Request $request)
    {
        $format = $request->get('format', 'json');

        $data = [
            'platform_overview' => [
                'total_umkm' => Profile::count(),
                'total_products' => Product::count(),
                'total_galleries' => Gallery::count(),
                'total_users' => User::where('role', 'umkm')->count(),
                'export_date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            'growth_statistics' => $this->calculateGrowthStats(),
            'monthly_trends' => $this->getMonthlyStatistics(),
            'top_umkm' => $this->getTopPerformingUmkm()->take(10)->toArray(),
            'platform_health' => [
                'avg_products_per_umkm' => $this->calculateAverageProductsPerUmkm(),
                'avg_galleries_per_umkm' => $this->calculateAverageGalleriesPerUmkm(),
                'complete_profile_percentage' => $this->calculateCompleteProfilePercentage(),
                'active_users_percentage' => $this->calculateActiveUsersPercentage(),
            ]
        ];

        switch ($format) {
            case 'csv':
                return $this->exportToCsv($data);
            case 'excel':
                return $this->exportToExcel($data);
            default:
                return response()->json($data);
        }
    }

    /**
     * Calculate average products per UMKM
     */
    private function calculateAverageProductsPerUmkm()
    {
        $totalUmkm = Profile::count();
        $totalProducts = Product::count();

        return $totalUmkm > 0 ? round($totalProducts / $totalUmkm, 1) : 0;
    }

    /**
     * Calculate average galleries per UMKM
     */
    private function calculateAverageGalleriesPerUmkm()
    {
        $totalUmkm = Profile::count();
        $totalGalleries = Gallery::count();

        return $totalUmkm > 0 ? round($totalGalleries / $totalUmkm, 1) : 0;
    }

    /**
     * Export data to CSV format
     */
    private function exportToCsv($data)
    {
        $filename = 'admin_dashboard_' . Carbon::now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Platform overview
            fputcsv($file, ['OVERVIEW PLATFORM']);
            fputcsv($file, ['Total UMKM', $data['platform_overview']['total_umkm']]);
            fputcsv($file, ['Total Produk', $data['platform_overview']['total_products']]);
            fputcsv($file, ['Total Galeri', $data['platform_overview']['total_galleries']]);
            fputcsv($file, ['Total Pengguna', $data['platform_overview']['total_users']]);
            fputcsv($file, ['Tanggal Export', $data['platform_overview']['export_date']]);
            fputcsv($file, []);

            // Growth statistics
            fputcsv($file, ['STATISTIK PERTUMBUHAN (%)']);
            fputcsv($file, ['Pertumbuhan UMKM', $data['growth_statistics']['umkm'] . '%']);
            fputcsv($file, ['Pertumbuhan Produk', $data['growth_statistics']['products'] . '%']);
            fputcsv($file, ['Pertumbuhan Galeri', $data['growth_statistics']['galleries'] . '%']);
            fputcsv($file, ['Pertumbuhan Pengguna', $data['growth_statistics']['users'] . '%']);
            fputcsv($file, []);

            // Platform health
            fputcsv($file, ['KESEHATAN PLATFORM']);
            fputcsv($file, ['Rata-rata Produk per UMKM', $data['platform_health']['avg_products_per_umkm']]);
            fputcsv($file, ['Rata-rata Galeri per UMKM', $data['platform_health']['avg_galleries_per_umkm']]);
            fputcsv($file, ['UMKM Profil Lengkap (%)', $data['platform_health']['complete_profile_percentage']]);
            fputcsv($file, ['Pengguna Aktif (%)', $data['platform_health']['active_users_percentage']]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data to Excel format (placeholder)
     */
    private function exportToExcel($data)
    {
        // This would require a library like PhpSpreadsheet
        return response()->json([
            'message' => 'Excel export feature coming soon',
            'data' => $data
        ]);
    }

    /**
     * Get real-time platform metrics
     */
    public function getRealTimeMetrics()
    {
        $today = Carbon::today();

        $metrics = [
            'today' => [
                'new_umkm' => Profile::whereDate('created_at', $today)->count(),
                'new_products' => Product::whereDate('created_at', $today)->count(),
                'new_galleries' => Gallery::whereDate('created_at', $today)->count(),
                'active_users' => User::where('role', 'umkm')
                    ->whereDate('updated_at', $today)
                    ->count(),
            ],
            'this_week' => [
                'new_umkm' => Profile::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
                'new_products' => Product::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
                'new_galleries' => Gallery::where('created_at', '>=', Carbon::now()->startOfWeek())->count(),
            ],
            'last_updated' => Carbon::now()->format('Y-m-d H:i:s')
        ];

        return response()->json($metrics);
    }

}
