<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\StockOpname;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $verifiedBooks = StockOpname::where('status', 'verified')->count();
        
        $userOpnameCount = StockOpname::where('user_id', auth()->id())
            ->where('status', 'verified')
            ->count();

        // Simple Leaderboard: Top 5 users with most verified opnames
        $leaderboard = User::withCount(['stockOpnames' => function ($query) {
                $query->where('status', 'verified');
            }])
            ->orderByDesc('stock_opnames_count')
            ->take(5)
            ->get()
            ->map(function ($user) {
                return [
                    'name' => $user->name,
                    'count' => $user->stock_opnames_count,
                    'avatar_url' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random',
                ];
            });

        return response()->json([
            'stats' => [
                'total_books' => $totalBooks,
                'verified_books' => $verifiedBooks, // Total already verified in system
                'user_verified' => $userOpnameCount, // Current user contribution
            ],
            'leaderboard' => $leaderboard,
        ]);
    }
}
