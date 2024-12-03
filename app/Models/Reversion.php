<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reversion extends Model
{
    use HasFactory;
    protected $fillable = ["loan_id","amount_penalty","returned_at"];
}
