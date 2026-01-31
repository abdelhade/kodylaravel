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
        Schema::create('item_units', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id')->nullable();
            $table->integer('unit_id')->nullable();
            $table->decimal('u_val', 10, 2)->nullable();
            $table->integer('def_sale')->nullable()->default(0);
            $table->integer('def_buy')->nullable()->default(0);
            $table->integer('def_stock')->nullable()->default(0);
            $table->integer('cost_price')->nullable();
            $table->decimal('price1', 10, 2)->nullable()->default(0.000);
            $table->decimal('price2', 10, 2)->nullable()->default(0.000);
            $table->decimal('price3', 10, 2)->nullable()->default(0.000);
            $table->decimal('price4', 10, 3)->nullable()->default(0.000);
            $table->string('unit_barcode')->nullable();
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
        Schema::dropIfExists('item_units');
    }
};
