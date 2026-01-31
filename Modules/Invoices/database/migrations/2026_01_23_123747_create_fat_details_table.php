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
        Schema::create('fat_details', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_tybe')->nullable();
            $table->integer('det_store')->nullable()->default(1);
            $table->integer('pro_id')->nullable();
            $table->integer('item_id')->nullable()->default(0);
            $table->decimal('u_val', 10, 2)->nullable()->default(1.000);
            $table->decimal('qty_in', 10, 2)->nullable()->default(0);
            $table->decimal('qty_out', 10, 2)->nullable()->default(0);
            $table->decimal('price', 10, 2)->nullable()->default(0);
            $table->decimal('cost_price', 12, 2)->nullable();
            $table->decimal('stock_value', 12, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('plus', 10, 2)->nullable();
            $table->decimal('det_value', 10, 2)->nullable()->default(0);
            $table->decimal('profit', 10, 2)->nullable()->default(0);
            $table->integer('fatid')->nullable();
            $table->integer('fat_tybe')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->integer('tenant')->nullable()->default(0);
            $table->integer('branch')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fat_details');
    }
};
