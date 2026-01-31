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
        Schema::create('attlog', function (Blueprint $table) {
            $table->id();
            $table->integer('employee')->nullable();
            $table->date('day')->nullable();
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable();
            $table->time('fpin')->nullable();
            $table->time('fpout')->nullable();
            $table->decimal('defhours', 8, 2)->nullable();
            $table->decimal('curhours', 8, 2)->nullable();
            $table->decimal('dueforhour', 8, 2)->nullable();
            $table->decimal('realdue', 8, 2)->nullable();
            $table->boolean('statue')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('info')->nullable();
            $table->integer('attdoc')->nullable();
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
        Schema::dropIfExists('attlog');
    }
};
