<?php
// FILE PATH: app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── KPI Stats ─────────────────────────────────────────────────
        $totalProducts   = Product::count();
        $totalValue      = Product::sum(DB::raw('price * quantity'));
        $lowStockCount   = Product::whereColumn('quantity', '<=', 'reorder_level')
                            ->where('quantity', '>', 0)
                            ->count();
        $outOfStock      = Product::where('quantity', 0)->count();
        $totalCategories = Category::count();
        $totalSuppliers  = Supplier::count();
        $totalMovements  = StockMovement::count();

        // ── Weekly stock in / out ──────────────────────────────────────
        $stockIn  = StockMovement::where('type', 'in')
                        ->where('created_at', '>=', now()->subDays(7))
                        ->sum('quantity');

        $stockOut = StockMovement::where('type', 'out')
                        ->where('created_at', '>=', now()->subDays(7))
                        ->sum('quantity');

        // ── Low stock products (for alert panel) ──────────────────────
        $lowStockProducts = Product::with('category')
                                ->whereColumn('quantity', '<=', 'reorder_level')
                                ->orderBy('quantity')
                                ->limit(6)
                                ->get();

        // ── Recent stock movements ─────────────────────────────────────
        $recentMovements = StockMovement::with(['product', 'user'])
                                ->latest()
                                ->limit(8)
                                ->get();

        // ── Category breakdown (for donut chart + cards) ──────────────
        $categoryData = Category::withCount('products')->get();

        // ── Top products by quantity (for bar chart) ───────────────────
        $topProducts = Product::orderByDesc('quantity')
                            ->limit(8)
                            ->get(['name', 'quantity', 'reorder_level'])
                            ->toArray();

        // ── Most valuable products ─────────────────────────────────────
        $valuableProducts = Product::orderByDesc(DB::raw('price * quantity'))
                                ->limit(5)
                                ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalValue',
            'lowStockCount',
            'outOfStock',
            'totalCategories',
            'totalSuppliers',
            'totalMovements',
            'stockIn',
            'stockOut',
            'lowStockProducts',
            'recentMovements',
            'categoryData',
            'topProducts',
            'valuableProducts'
        ));
    }
}