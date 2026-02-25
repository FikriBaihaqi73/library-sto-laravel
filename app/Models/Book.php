<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'place_of_publication',
        'year_of_publication',
        'item_code',
        'isbn_issn',
        'language',
        'collation',
        'gmd_type',
        'classification',
        'call_number',
        'subject',
        'abstract',
        'cover_image',
        'total_items',
        'edition',
        'frequency_of_publication',
        'series_title',
        'attachment',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'total_items' => 'integer',
    ];

    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class);
    }
}
