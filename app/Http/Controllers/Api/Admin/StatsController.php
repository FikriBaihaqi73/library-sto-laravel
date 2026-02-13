<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index()
    {
        $totalBooks = \App\Models\Book::count();
        $verifiedBooks = \App\Models\StockOpname::where('status', 'verified')->count();
        $conditions = \App\Models\StockOpname::select('condition', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->whereNotNull('condition')
            ->groupBy('condition')
            ->get();
        
        $contributors = \App\Models\User::withCount('stockOpnames')
            ->orderByDesc('stock_opnames_count')
            ->take(5)
            ->get();

        return response()->json([
            'overview' => [
                'total_books' => $totalBooks,
                'verified' => $verifiedBooks,
                'progress_percentage' => $totalBooks > 0 ? round(($verifiedBooks / $totalBooks) * 100, 1) : 0,
            ],
            'conditions' => $conditions,
            'contributors' => $contributors,
        ]);
    }
}
