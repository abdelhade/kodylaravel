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
        Schema::create('closed_orders', function (Blueprint $table) {
            $table->id();
            $table->string('shift')->nullable();
            $table->string('user', 10)->nullable();
            $table->date('date')->nullable();
            $table->datetime('strttime')->nullable();
            $table->time('endtime')->nullable();
            $table->decimal('total_sales', 10, 2)->nullable()->default(0);
            $table->decimal('delevery', 10, 2)->nullable()->default(0);
            $table->decimal('tables', 10, 2)->nullable()->default(0);
            $table->decimal('takeaway', 10, 2)->nullable()->default(0);
            $table->decimal('expenses', 10, 2)->nullable()->default(0);
            $table->decimal('fund_before', 10, 2)->nullable()->default(0);
            $table->decimal('fund_after', 10, 2)->nullable()->default(0);
            $table->string('exp_notes', 30)->nullable();
            $table->decimal('cash', 10, 2)->nullable()->default(0);
            $table->string('info', 50)->nullable();
            $table->datetime('crtime')->nullable()->useCurrent();
            $table->datetime('mdtime')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->string('info2', 20)->nullable();
            $table->integer('tenant')->nullable()->default(1);
            $table->integer('branch')->nullable()->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closed_orders');
    }
};
