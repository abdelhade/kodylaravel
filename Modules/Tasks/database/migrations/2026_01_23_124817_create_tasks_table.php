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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('ch_tybe')->nullable();
            $table->text('info')->nullable();
            $table->string('phone', 20)->nullable();
            $table->integer('user')->nullable();
            $table->integer('tasktybe')->nullable();
            $table->boolean('important')->nullable();
            $table->boolean('urgent')->nullable();
            $table->string('emp_comment', 200)->nullable();
            $table->string('cl_comment', 200)->nullable();
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
        Schema::dropIfExists('tasks');
    }
};
