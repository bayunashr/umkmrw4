<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the UMKM dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        // Get basic counts
        $productsCount = $profile->products()->count();
        $galleriesCount = $profile->galleries()->count();
        $socialMediaCount = $profile->socialMedia()->count();

        // Calculate profile completeness
        $profileCompleteness = $this->calculateProfileCompleteness($profile);

        // Get recent activities
        $recentProducts = $profile->products()
            ->latest()
            ->take(5)
            ->get();

        $recentGalleries = $profile->galleries()
            ->latest()
            ->take(5)
            ->get();

        // Get monthly statistics for charts
        $monthlyStats = $this->getMonthlyStatistics($profile);

        // Calculate growth percentages
        $growthStats = $this->calculateGrowthStats($profile);

        return view('dashboard.index', compact(
            'profile',
            'productsCount',
            'galleriesCount',
            'socialMediaCount',
            'profileCompleteness',
            'recentProducts',
            'recentGalleries',
            'monthlyStats',
            'growthStats'
        ));
    }

    /**
     * Calculate profile completeness percentage
     */
    private function calculateProfileCompleteness($profile)
    {
        $fields = [
            'name' => !empty($profile->name),
            'description' => !empty($profile->description),
            'address' => !empty($profile->address),
            'phone' => !empty($profile->phone),
            'logo_path' => !empty($profile->logo_path),
            'cover_path' => !empty($profile->cover_path),
            'latitude' => !empty($profile->latitude),
            'longitude' => !empty($profile->longitude),
            'rt' => !empty($profile->rt),
            'rw' => !empty($profile->rw),
        ];

        // Additional points for content
        $hasProducts = $profile->products()->count() > 0;
        $hasGalleries = $profile->galleries()->count() > 0;
        $hasSocialMedia = $profile->socialMedia()->count() > 0;

        $fields['products'] = $hasProducts;
        $fields['galleries'] = $hasGalleries;
        $fields['social_media'] = $hasSocialMedia;

        $completedFields = array_filter($fields);
        $totalFields = count($fields);

        return round((count($completedFields) / $totalFields) * 100);
    }

    /**
     * Get monthly statistics for the last 6 months
     */
    private function getMonthlyStatistics($profile)
    {
        $months = [];
        $productData = [];
        $galleryData = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $months[] = $month->format('M');

            // Count products created in this month
            $productCount = $profile->products()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            // Count galleries created in this month
            $galleryCount = $profile->galleries()
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $productData[] = $productCount;
            $galleryData[] = $galleryCount;
        }

        return [
            'months' => $months,
            'products' => $productData,
            'galleries' => $galleryData
        ];
    }

    /**
     * Calculate growth statistics
     */
    private function calculateGrowthStats($profile)
    {
        $currentMonth = Carbon::now();
        $lastMonth = Carbon::now()->subMonth();

        // Products growth
        $currentMonthProducts = $profile->products()
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthProducts = $profile->products()
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $productGrowth = $this->calculatePercentageGrowth($lastMonthProducts, $currentMonthProducts);

        // Galleries growth
        $currentMonthGalleries = $profile->galleries()
            ->whereYear('created_at', $currentMonth->year)
            ->whereMonth('created_at', $currentMonth->month)
            ->count();

        $lastMonthGalleries = $profile->galleries()
            ->whereYear('created_at', $lastMonth->year)
            ->whereMonth('created_at', $lastMonth->month)
            ->count();

        $galleryGrowth = $this->calculatePercentageGrowth($lastMonthGalleries, $currentMonthGalleries);

        // Social media growth (simulated based on total count)
        $socialGrowth = min(100, $profile->socialMedia()->count() * 25);

        return [
            'products' => $productGrowth,
            'galleries' => $galleryGrowth,
            'social_media' => $socialGrowth
        ];
    }

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
     * Get business insights and tips
     */
    public function getBusinessInsights()
    {
        $user = Auth::user();
        $profile = $user->umkmProfile;

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $insights = [];

        // Product insights
        $productsCount = $profile->products()->count();
        if ($productsCount < 5) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'ri-shopping-bag-line',
                'title' => 'Tambah Lebih Banyak Produk',
                'message' => 'Anda memiliki ' . $productsCount . ' produk. Minimal 5-10 produk untuk menarik lebih banyak customer.',
                'action' => route('umkm.products.create'),
                'action_text' => 'Tambah Produk'
            ];
        }

        // Gallery insights
        $galleriesCount = $profile->galleries()->count();
        if ($galleriesCount < 10) {
            $insights[] = [
                'type' => 'info',
                'icon' => 'ri-camera-line',
                'title' => 'Upload Lebih Banyak Foto',
                'message' => 'Anda memiliki ' . $galleriesCount . ' foto. Foto berkualitas meningkatkan kepercayaan customer.',
                'action' => route('umkm.galleries.create'),
                'action_text' => 'Upload Foto'
            ];
        }

        // Social media insights
        $socialMediaCount = $profile->socialMedia()->count();
        if ($socialMediaCount < 3) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'ri-share-line',
                'title' => 'Tambah Media Sosial',
                'message' => 'Anda terhubung di ' . $socialMediaCount . ' platform. Perluas jangkauan dengan Instagram, Facebook, TikTok.',
                'action' => route('umkm.social-media.index'),
                'action_text' => 'Kelola Sosmed'
            ];
        }

        // Profile completeness insights
        $completeness = $this->calculateProfileCompleteness($profile);
        if ($completeness < 80) {
            $insights[] = [
                'type' => 'warning',
                'icon' => 'ri-user-settings-line',
                'title' => 'Lengkapi Profil',
                'message' => 'Profil Anda ' . $completeness . '% lengkap. Profil lengkap meningkatkan kredibilitas bisnis.',
                'action' => route('umkm.profile.edit'),
                'action_text' => 'Edit Profil'
            ];
        }

        // Success message if everything is good
        if (empty($insights)) {
            $insights[] = [
                'type' => 'success',
                'icon' => 'ri-trophy-line',
                'title' => '🎉 Bisnis Anda Sudah Terkelola Dengan Baik!',
                'message' => 'Terus pertahankan dan tingkatkan kualitas produk serta layanan Anda.',
                'action' => null,
                'action_text' => null
            ];
        }

        return response()->json($insights);
    }

    /**
     * Get dashboard statistics for API/AJAX calls
     */
    public function getStatistics()
    {
        $user = Auth::user();
        $profile = $user->umkmProfile;

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $stats = [
            'products' => [
                'count' => $profile->products()->count(),
                'recent' => $profile->products()->latest()->take(3)->get(['name', 'created_at']),
                'with_images' => $profile->products()->whereNotNull('image_path')->count()
            ],
            'galleries' => [
                'count' => $profile->galleries()->count(),
                'recent' => $profile->galleries()->latest()->take(3)->get(['caption', 'created_at']),
                'size_mb' => $this->calculateGallerySize($profile)
            ],
            'social_media' => [
                'count' => $profile->socialMedia()->count(),
                'platforms' => $profile->socialMedia()->pluck('platform')->toArray()
            ],
            'profile_completeness' => $this->calculateProfileCompleteness($profile),
            'monthly_stats' => $this->getMonthlyStatistics($profile),
            'growth_stats' => $this->calculateGrowthStats($profile)
        ];

        return response()->json($stats);
    }

    /**
     * Calculate total gallery size (simulated)
     */
    private function calculateGallerySize($profile)
    {
        // Simulate file size calculation
        // In real implementation, you would check actual file sizes
        $galleryCount = $profile->galleries()->count();
        return round($galleryCount * 2.5, 1); // Assume average 2.5MB per image
    }

    /**
     * Export dashboard data
     */
    public function exportData(Request $request)
    {
        $user = Auth::user();
        $profile = $user->umkmProfile;

        if (!$profile) {
            return response()->json(['error' => 'Profile not found'], 404);
        }

        $format = $request->get('format', 'json'); // json, csv, pdf

        $data = [
            'profile' => [
                'name' => $profile->name,
                'description' => $profile->description,
                'address' => $profile->address,
                'phone' => $profile->phone,
                'completeness' => $this->calculateProfileCompleteness($profile) . '%'
            ],
            'statistics' => [
                'products_count' => $profile->products()->count(),
                'galleries_count' => $profile->galleries()->count(),
                'social_media_count' => $profile->socialMedia()->count(),
                'export_date' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            'products' => $profile->products()->get(['name', 'price', 'description', 'created_at']),
            'galleries' => $profile->galleries()->get(['caption', 'created_at']),
            'social_media' => $profile->socialMedia()->get(['platform', 'url'])
        ];

        switch ($format) {
            case 'csv':
                return $this->exportToCsv($data);
            case 'pdf':
                return $this->exportToPdf($data);
            default:
                return response()->json($data);
        }
    }

    /**
     * Export data to CSV format
     */
    private function exportToCsv($data)
    {
        $filename = 'umkm_dashboard_' . Carbon::now()->format('Y_m_d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($data) {
            $file = fopen('php://output', 'w');

            // Profile summary
            fputcsv($file, ['PROFIL UMKM']);
            fputcsv($file, ['Nama', $data['profile']['name']]);
            fputcsv($file, ['Deskripsi', $data['profile']['description']]);
            fputcsv($file, ['Alamat', $data['profile']['address']]);
            fputcsv($file, ['Telepon', $data['profile']['phone']]);
            fputcsv($file, ['Kelengkapan', $data['profile']['completeness']]);
            fputcsv($file, []);

            // Statistics
            fputcsv($file, ['STATISTIK']);
            fputcsv($file, ['Jumlah Produk', $data['statistics']['products_count']]);
            fputcsv($file, ['Jumlah Galeri', $data['statistics']['galleries_count']]);
            fputcsv($file, ['Jumlah Media Sosial', $data['statistics']['social_media_count']]);
            fputcsv($file, []);

            // Products
            fputcsv($file, ['PRODUK']);
            fputcsv($file, ['Nama', 'Harga', 'Deskripsi', 'Tanggal Dibuat']);
            foreach ($data['products'] as $product) {
                fputcsv($file, [
                    $product['name'],
                    $product['price'],
                    $product['description'],
                    $product['created_at']
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export data to PDF format
     */
    private function exportToPdf($data)
    {
        // This would require a PDF library like DomPDF or TCPDF
        // For now, return JSON with a message
        return response()->json([
            'message' => 'PDF export feature coming soon',
            'data' => $data
        ]);
    }
}
