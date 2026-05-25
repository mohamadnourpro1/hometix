<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Keep existing `price` intact for backward compatibility.
            $table->decimal('price_usd', 10, 2)->nullable()->after('price');
            $table->decimal('price_try', 10, 2)->nullable()->after('price_usd');
            $table->decimal('price_syp', 14, 2)->nullable()->after('price_try');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['price_usd', 'price_try', 'price_syp']);
        });
    }
};

