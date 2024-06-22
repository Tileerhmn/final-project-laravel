<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public $timestamps = true;
    public $incrementing = true;

    // relation to books table

    public function books()
    {
        return $this->hasMany(Books::class, 'category_id', 'id');
    }
}
