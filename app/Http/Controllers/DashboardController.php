<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalGalleryItems = Gallery::count();
        $recentProducts = Product::latest()->take(5)->get();
        $recentGallery = Gallery::latest()->take(6)->get();
        return view('dashboard.index', compact('totalProducts', 'totalGalleryItems', 'recentProducts', 'recentGallery'));
    }
}
