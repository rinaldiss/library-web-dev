<?php

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
        Schema::create('magazines', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('magazine_serial_number')->nullable();
            $table->string('number')->nullable();
            $table->string('volume')->nullable();
            $table->string('times_published')->nullable();
            $table->string('issn')->nullable();
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('place_of_publication')->nullable();
            $table->integer('year_of_publication')->nullable();
            $table->string('classification')->nullable();
            $table->string('place_of_origin')->nullable();
            $table->text('note')->nullable();
            $table->integer('stock')->default(10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('magazines');
    }
};