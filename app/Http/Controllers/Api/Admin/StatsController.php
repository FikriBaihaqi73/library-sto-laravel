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
        
        $contributors = \App\Models\User::withCount(['stockOpnames' => function($q) {
                $q->where('status', 'verified');
            }])
            ->withSum(['stockOpnames as total_commission' => function($q) {
                $q->where('status', 'verified');
            }], 'earned_commission')
            ->orderByDesc('stock_opnames_count')
            ->take(5)
            ->get();

        $totalCommission = \App\Models\StockOpname::where('status', 'verified')->sum('earned_commission');
        $currentCommission = \App\Models\Setting::where('key', 'commission')->first();

        return response()->json([
            'overview' => [
                'total_books' => $totalBooks,
                'verified' => $verifiedBooks,
                'total_commission' => (float)$totalCommission,
                'current_commission' => $currentCommission ? (float)$currentCommission->value : 0,
                'progress_percentage' => $totalBooks > 0 ? round(($verifiedBooks / $totalBooks) * 100, 1) : 0,
            ],
            'conditions' => $conditions,
            'contributors' => $contributors,
        ]);
    }
}
