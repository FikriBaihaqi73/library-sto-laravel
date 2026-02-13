<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockOpname extends Model
{
    /** @use HasFactory<\Database\Factories\StockOpnameFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'status',
        'condition',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
