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
        Schema::create('oppatterns', function (Blueprint $table) {
            $table->id();
            $table->string('pame', 100)->nullable();
            $table->string('ptext', 100)->nullable();
            $table->integer('def_width')->nullable()->default(50);
            $table->integer('cur_width')->nullable()->default(50);
            $table->integer('shown')->nullable()->default(1);
            $table->integer('is_edit')->nullable()->default(1);
            $table->integer('is_print')->nullable()->default(1);
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
        Schema::dropIfExists('oppatterns');
    }
};
