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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('empid')->nullable();
            $table->string('info', 100)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable();
            $table->decimal('salary', 10, 2)->nullable()->default(0);
            $table->decimal('extra', 10, 2)->nullable()->default(0);
            $table->decimal('disc', 10, 2)->nullable()->default(0);
            $table->decimal('allow', 10, 2)->nullable()->default(0);
            $table->decimal('dedu', 10, 2)->nullable()->default(0);
            $table->decimal('total', 10, 2)->nullable()->default(0);
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
        Schema::dropIfExists('salaries');
    }
};
