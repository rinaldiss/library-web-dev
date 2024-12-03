<?php

use App\Models\Loan;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reversions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Loan::class)->nullable();
            $table->date("returned_at")->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reversions');
    }
};
