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
        Schema::create('emplog', function (Blueprint $table) {
            $table->id();
            $table->integer('employee')->nullable();
            $table->date('date')->nullable();
            $table->time('chkin')->nullable();
            $table->time('chkout')->nullable();
            $table->time('addin')->nullable();
            $table->time('addout')->nullable();
            $table->decimal('latecost', 8, 2)->nullable();
            $table->decimal('earlcost', 8, 2)->nullable();
            $table->integer('absent')->nullable();
            $table->integer('holiday')->nullable();
            $table->decimal('deducation', 8, 2)->nullable();
            $table->decimal('additional', 8, 2)->nullable();
            $table->integer('user')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('emplog');
    }
};
