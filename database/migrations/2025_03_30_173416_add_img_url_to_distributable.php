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
        Schema::table('distributables', function (Blueprint $table) {

            $table->string('img_url')->nullable()->after('synopsis');
            $table->string('thumbnail')->nullable()->after('img_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributables', function (Blueprint $table) {
            $table->dropColumn(['img_url', 'thumbnail']);
        });
    }
};
