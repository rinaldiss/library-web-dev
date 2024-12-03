<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $fillable = ["visitor_id","book_id","magazine_id","regulation_id","type","loan_at","amount_penalty","expired_at","status"];

    /**
     * Get the visitor that owns the Loan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }
}
