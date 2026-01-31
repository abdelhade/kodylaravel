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
        Schema::create('emp_kbis', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id')->nullable();
            $table->integer('kbi_id')->nullable();
            $table->decimal('kbi_weight', 10, 2)->nullable();
            $table->decimal('kbi_rate', 10, 2)->nullable();
            $table->decimal('kbi_sum', 10, 2)->nullable();
            $table->integer('user')->nullable()->default(1);
            $table->datetime('crtime')->nullable()->useCurrent();
            $table->datetime('mdtime')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->boolean('tenant')->nullable()->default(0);
            $table->boolean('branch')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_kbis');
    }
};
