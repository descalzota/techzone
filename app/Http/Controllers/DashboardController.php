<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProducts'   => Product::count(),
            'totalStock'      => Product::sum('quantity'),
            'lowStockCount'   => Product::where('status', 'Low Stock')->count(),
            'totalCategories' => Product::distinct()->count('category'),
        ]);
    }
}