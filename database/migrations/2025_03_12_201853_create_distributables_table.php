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
        Schema::create('distributables', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->timestamps();
            $table->boolean('checked_in')->default(true);
            $table->string('title')->nullable();
            $table->string('author')->nullable();
            $table->date('published_date')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('isbn')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributables');
    }
};
