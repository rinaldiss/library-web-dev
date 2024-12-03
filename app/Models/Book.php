<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'book_serial_number',
        'edition',
        'volume',
        'printed',
        'isbn',
        'author',
        'publisher',
        'place_of_publication',
        'year_of_publication',
        'classification',
        'place_of_origin',
        'note',
        'dokumen',
        'stock',
    ];
}
