<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $primaryKey = 'isbn';

    protected $fillable = [
        'isbn',
        'title',
        'image',
        'description',
        'category_id',
        'author_id',
    ];

    public $timestamps = true;
    public $incrementing = false;

    // relation to categories table

    public function categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }

    // relation to authors table

    public function authors()
    {
        return $this->belongsTo(Authors::class, 'author_id', 'id');
    }

    // relation to books_borrowings table

    public function booksBorrowings()
    {
        return $this->hasMany(BooksBorrowings::class, 'book_id', 'isbn');
    }
}
