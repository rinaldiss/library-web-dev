<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reversion extends Model
{
    use HasFactory;
    protected $fillable = ["loan_id","penalty","returned_at"];

    /**
     * Get the loan that owns the Reversion
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function loan()
    {
        return $this->belongsTo(Loan::class, 'loan_id', 'id');
    }
}
