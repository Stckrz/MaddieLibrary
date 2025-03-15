<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('patrons', function (Blueprint $table) {
            $table->string('firstName')->nullable();
            $table->string('lastName')->nullable();
        });
        DB::table('patrons')->get()->each(function ($patron) {
            if ($patron->name) {
                $parts = explode(' ', $patron->name, 2);
                DB::table('patrons')
                    ->where('id', $patron->id)
                    ->update([
                        'firstName' => $parts[0],
                        'lastName' => $parts[1] ?? '',
                    ]);
            }
        });
        Schema::table('patrons', function (Blueprint $table) {
            $table->dropColumn('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('patrons', function (Blueprint $table) {
            $table->string('name')->nullable();
        });
        DB::table('patrons')->get()->each(function ($patron){
            DB::table('patrons')
                ->where('id', $patron->id)
                ->update([
                    'name' => trim($patron->firstName . ' ' . $patron->lastName)
                ]);
        });

    }
};
