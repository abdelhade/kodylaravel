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
        Schema::create('shw_optns', function (Blueprint $table) {
            $table->id();
            $table->string('sname')->nullable();
            $table->integer('is_show')->nullable()->default(0);
            $table->integer('def_width')->nullable()->default(50);
            $table->integer('cur_width')->nullable()->default(50);
            $table->string('info', 150)->nullable();
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
        Schema::dropIfExists('shw_optns');
    }
};
