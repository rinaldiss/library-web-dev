<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Regulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'regulation_serial_number',
        'regulation_type',
        'number_and_year_of_regulation',
        'place_and_number_of_regulation',
        'author',
        'place_of_publication',
        'publisher',
        'year_of_publication',
        'classification',
        'place_of_origin',
        'note'
    ];
}
