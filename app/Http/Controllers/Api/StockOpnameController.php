<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\StockOpname;

class StockOpnameController extends Controller
{
    public function searchBook($isbn)
    {
        $book = Book::where('isbn', $isbn)->first();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Check if book is already verified by ANY user
        $existingOpname = StockOpname::where('book_id', $book->id)
            ->where('status', 'verified')
            ->with('user') // Eager load user to show who verified it
            ->first();

        return response()->json([
            'book' => $book,
            'status' => $existingOpname ? 'verified' : 'pending_scan',
            'verified_by' => $existingOpname ? $existingOpname->user->name : null,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'status' => 'required|string',
        ]);

        // Double check before saving to prevent race conditions
        $isVerified = StockOpname::where('book_id', $request->book_id)
            ->where('status', 'verified')
            ->exists();

        if ($isVerified) {
             return response()->json(['message' => 'Book already verified by another user.'], 400);
        }

        $opname = StockOpname::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Stock opname recorded successfully',
            'data' => $opname,
        ]);
    }
}
