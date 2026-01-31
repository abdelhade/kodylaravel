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
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->integer('snd_id')->nullable();
            $table->date('date')->nullable();
            $table->string('emp_name')->nullable();
            $table->decimal('qty', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->string('info', 150)->nullable();
            $table->string('info2', 150)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('user')->nullable()->default(1);
            $table->integer('isdeleted')->nullable()->default(0);
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
        Schema::dropIfExists('productions');
    }
};
