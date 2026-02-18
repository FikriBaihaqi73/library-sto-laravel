<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(\App\Models\Book::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'title'                    => 'required|string|max:255',
            'author'                   => 'required|string|max:255',
            'publisher'                => 'required|string|max:255',
            'place_of_publication'     => 'required|string|max:255',
            'year_of_publication'      => 'required|string|max:4',
            'isbn_issn'                => 'nullable|string|max:30',
            'language'                 => 'nullable|string|max:50',
            'collation'                => 'nullable|string|max:255',
            'gmd_type'                 => 'nullable|string|max:100',
            'classification'           => 'nullable|string|max:100',
            'call_number'              => 'nullable|string|max:100',
            'subject'                  => 'nullable|string|max:255',
            'abstract'                 => 'nullable|string',
            'cover_image'              => 'nullable|string|max:500',
            'total_items'              => 'nullable|integer|min:0',
            'edition'                  => 'nullable|string|max:50',
            'frequency_of_publication' => 'nullable|string|max:100',
            'series_title'             => 'nullable|string|max:255',
            'attachment'               => 'nullable|string|max:500',
            'is_featured'              => 'nullable|boolean',
        ]);

        $book = \App\Models\Book::create($validated);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(\App\Models\Book::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $book = \App\Models\Book::findOrFail($id);

        $validated = $request->validate([
            'title'                    => 'sometimes|string|max:255',
            'author'                   => 'sometimes|string|max:255',
            'publisher'                => 'sometimes|string|max:255',
            'place_of_publication'     => 'sometimes|string|max:255',
            'year_of_publication'      => 'sometimes|string|max:4',
            'isbn_issn'                => 'nullable|string|max:30',
            'language'                 => 'nullable|string|max:50',
            'collation'                => 'nullable|string|max:255',
            'gmd_type'                 => 'nullable|string|max:100',
            'classification'           => 'nullable|string|max:100',
            'call_number'              => 'nullable|string|max:100',
            'subject'                  => 'nullable|string|max:255',
            'abstract'                 => 'nullable|string',
            'cover_image'              => 'nullable|string|max:500',
            'total_items'              => 'nullable|integer|min:0',
            'edition'                  => 'nullable|string|max:50',
            'frequency_of_publication' => 'nullable|string|max:100',
            'series_title'             => 'nullable|string|max:255',
            'attachment'               => 'nullable|string|max:500',
            'is_featured'              => 'nullable|boolean',
        ]);

        $book->update($validated);

        return response()->json($book);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = \App\Models\Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully']);
    }
}
