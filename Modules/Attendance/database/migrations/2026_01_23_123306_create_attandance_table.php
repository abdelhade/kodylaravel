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
        Schema::create('attandance', function (Blueprint $table) {
            $table->id();
            $table->integer('employee')->nullable();
            $table->integer('fptybe')->nullable();
            $table->date('fpdate')->nullable();
            $table->time('time')->nullable();
            $table->integer('user')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->string('fromwhere', 10)->nullable();
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
        Schema::dropIfExists('attandance');
    }
};
