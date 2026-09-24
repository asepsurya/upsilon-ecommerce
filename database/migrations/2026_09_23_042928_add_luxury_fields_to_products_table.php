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
        Schema::table('products', function (Blueprint $table) {
            $table->string('badge')->nullable()->after('is_bestseller');
            $table->string('edition')->nullable()->after('badge');
            $table->string('subtitle')->nullable()->after('edition');
            $table->string('bottom_label')->nullable()->after('subtitle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['badge', 'edition', 'subtitle', 'bottom_label']);
        });
    }
};
