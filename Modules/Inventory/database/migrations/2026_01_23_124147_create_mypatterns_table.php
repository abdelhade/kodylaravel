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
        Schema::create('mypatterns', function (Blueprint $table) {
            $table->id();
            $table->string('pname')->nullable();
            $table->string('ptext')->nullable();
            $table->integer('is_def')->nullable()->default(0);
            $table->integer('is_basic')->nullable()->default(0);
            $table->integer('ptybe')->nullable()->default(4);
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent();
            $table->string('info', 100)->nullable();
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
        Schema::dropIfExists('mypatterns');
    }
};
