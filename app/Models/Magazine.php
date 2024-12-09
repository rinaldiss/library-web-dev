<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Magazine extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'magazine_serial_number',
        'number',
        'volume',
        'times_published',
        'issn',
        'author',
        'publisher',
        'place_of_publication',
        'year_of_publication',
        'classification',
        'place_of_origin',
        'note',
        'dokumen',
        "stock"
    ];
}
