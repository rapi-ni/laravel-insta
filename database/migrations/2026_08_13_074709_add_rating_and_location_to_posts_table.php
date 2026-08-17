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
        Schema::table('posts', function (Blueprint $table) {
            $table->decimal('rating_taste', 2, 1)->nullable()->after('description');
        $table->decimal('rating_volume', 2, 1)->nullable()->after('rating_taste');
        $table->decimal('rating_sulit', 2, 1)->nullable()->after('rating_volume');
        $table->decimal('rating_vibes', 2, 1)->nullable()->after('rating_sulit');
        
        $table->foreignId('location_id')->nullable()->after('rating_vibes')->constrained()->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
