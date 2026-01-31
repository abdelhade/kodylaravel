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
        Schema::create('zankat', function (Blueprint $table) {
            $table->id();
            $table->string('zname')->nullable();
            $table->boolean('colors')->nullable()->default(1);
            $table->boolean('ctp')->nullable();
            $table->boolean('zncase')->nullable();
            $table->boolean('print')->nullable();
            $table->boolean('ptype')->nullable();
            $table->boolean('service')->nullable();
            $table->boolean('prod')->nullable();
            $table->boolean('measure')->nullable();
            $table->boolean('draw')->nullable();
            $table->boolean('farkh')->nullable();
            $table->string('info', 255)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->string('date')->nullable();
            $table->string('user')->nullable();
            $table->integer('fatid')->nullable()->default(0);
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
        Schema::dropIfExists('zankat');
    }
};
