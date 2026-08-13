<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedTinyInteger('spicy_level')->nullable()->after('introduction');
            $table->unsignedTinyInteger('sweet_level')->nullable()->after('spicy_level');
            $table->unsignedTinyInteger('meat_level')->nullable()->after('sweet_level');
            $table->unsignedTinyInteger('vegetable_level')->nullable()->after('meat_level');
            $table->text('favorite_foods')->nullable()->after('vegetable_level');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'spicy_level',
                'sweet_level',
                'meat_level',
                'vegetable_level',
                'favorite_foods',
            ]);
        });
    }
};
