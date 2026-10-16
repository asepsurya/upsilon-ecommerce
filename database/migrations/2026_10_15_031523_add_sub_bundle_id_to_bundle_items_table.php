<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bundle_items', function (Blueprint $table) {
            $table->foreignId('sub_bundle_id')->nullable()->after('bundle_id')->constrained('sub_bundles')->nullOnDelete();
            $table->string('custom_name')->nullable()->after('product_id');
            $table->integer('sort_order')->default(0)->after('quantity');
        });
    }

    public function down(): void
    {
        Schema::table('bundle_items', function (Blueprint $table) {
            $table->dropForeign(['sub_bundle_id']);
            $table->dropColumn(['sub_bundle_id', 'custom_name', 'sort_order']);
        });
    }
};
