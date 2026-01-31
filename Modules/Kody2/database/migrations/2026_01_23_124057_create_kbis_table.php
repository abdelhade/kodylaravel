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
        Schema::create('kbis', function (Blueprint $table) {
            $table->id();
            $table->string('kname')->nullable();
            $table->string('info', 100)->nullable();
            $table->integer('user')->nullable()->default(1);
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->datetime('crtime')->nullable()->useCurrent();
            $table->datetime('mdtime')->nullable()->useCurrent()->useCurrentOnUpdate();
            $table->string('ktybe', 100)->nullable();
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
        Schema::dropIfExists('kbis');
    }
};
