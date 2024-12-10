<?php

use App\Models\Book;
use App\Models\Magazine;
use App\Models\Member;
use App\Models\Regulation;
use App\Models\Visitor;
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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)->nullable();
            $table->foreignIdFor(Magazine::class)->nullable();
            $table->foreignIdFor(Regulation::class)->nullable();
            $table->foreignIdFor(Member::class);
            $table->enum("type",["book","magazine","regulation"]);
            $table->timestamp("loan_at")->default(now());
            $table->timestamp("expired_at")->default(now());
            $table->enum("status",["on_going","finished"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
