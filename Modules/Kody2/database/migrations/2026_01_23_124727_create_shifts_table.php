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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('info')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->time('shiftstart')->nullable();
            $table->time('shiftend')->nullable();
            $table->decimal('hours', 11, 2)->nullable();
            $table->time('instart')->nullable();
            $table->time('inend')->nullable();
            $table->time('outstart')->nullable();
            $table->time('outend')->nullable();
            $table->boolean('latelimit')->nullable();
            $table->integer('earlylimit')->nullable();
            $table->string('workingdays', 20)->nullable();
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
        Schema::dropIfExists('shifts');
    }
};
