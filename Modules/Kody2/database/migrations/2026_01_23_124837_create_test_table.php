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
        Schema::create('test', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 15)->nullable();
            $table->datetime('created')->nullable();
            $table->datetime('modified')->nullable();
            $table->string('status')->nullable()->default('Active');
            $table->string('name', 50)->nullable();
            $table->date('date')->nullable();
            $table->string('test', 1)->nullable();
            $table->time('time')->nullable();
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
        Schema::dropIfExists('test');
    }
};
