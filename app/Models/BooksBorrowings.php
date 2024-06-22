<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BooksBorrowings extends Model
{
    use HasFactory;

    protected $table = 'books_borrowings';

    protected $fillable = [
        'book_id',
        'user_id',
        'borrowed_at',
        'returned_at',
    ];

    public $timestamps = true;

    // relation to books table

    public function books()
    {
        return $this->belongsTo(Books::class, 'book_id', 'isbn');
    }

    // relation to users table

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
