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

            $table->string('studio')->nullable()->after('synopsis');
            $table->string('platform')->nullable()->after('studio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('distributables', function (Blueprint $table) {
            $table->dropColumn(['artist', 'release_date']);
        });
    }
};
