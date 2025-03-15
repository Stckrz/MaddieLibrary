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
            // Add CD-specific fields if they don't already exist
            $table->string('artist')->nullable()->after('synopsis');
            $table->date('release_date')->nullable()->after('artist');
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
