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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->integer('client')->nullable();
            $table->string('diseses', 250)->nullable()->default(0);
            $table->string('phone', 15)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('duration', 8, 2)->nullable();
            $table->integer('visittybe')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('paid')->nullable()->default(0);
            $table->integer('deserved')->nullable()->default(0);
            $table->integer('rest')->nullable()->default(0);
            $table->integer('done')->nullable()->default(0);
            $table->string('info', 250)->nullable();
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
        Schema::dropIfExists('reservations');
    }
};
