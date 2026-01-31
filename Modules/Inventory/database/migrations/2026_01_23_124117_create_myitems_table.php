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
        Schema::create('myitems', function (Blueprint $table) {
            $table->id();
            $table->string('iname')->nullable();
            $table->string('name2', 200)->nullable();
            $table->integer('code')->nullable();
            $table->decimal('salesqty', 10, 2)->nullable()->default(1);
            $table->string('barcode', 25)->nullable();
            $table->decimal('itmqty', 10, 2)->nullable()->default(0);
            $table->string('info', 250)->nullable();
            $table->decimal('market_price', 10, 2)->nullable()->default(0);
            $table->decimal('cost_price', 10, 2)->nullable()->default(0);
            $table->integer('last_price')->nullable()->default(0);
            $table->decimal('price1', 10, 2)->nullable()->default(0);
            $table->decimal('price2', 10, 2)->nullable()->default(0);
            $table->decimal('price3', 10, 2)->nullable();
            $table->integer('group1')->nullable()->default(0);
            $table->integer('group2')->nullable()->default(0);
            $table->integer('group3')->nullable()->default(0);
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('user')->nullable()->default(1);
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
        Schema::dropIfExists('myitems');
    }
};
