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
        'isbn',
        'author',
        'cover_url',
        'stock_system',
        'category',
    ];

    public function stockOpnames()
    {
        return $this->hasMany(StockOpname::class);
    }
}
