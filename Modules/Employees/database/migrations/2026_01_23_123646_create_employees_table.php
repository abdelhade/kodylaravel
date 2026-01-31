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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('basma_id')->nullable();
            $table->string('basma_name', 50)->nullable();
            $table->string('name', 100)->nullable();
            $table->string('info', 250)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->string('imgs', 250)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('number', 13)->nullable();
            $table->boolean('active')->nullable()->default(1);
            $table->date('dateofbirth')->nullable();
            $table->string('gender', 10)->nullable();
            $table->integer('country')->nullable();
            $table->string('address', 250)->nullable();
            $table->string('address2', 250)->nullable();
            $table->integer('town')->nullable();
            $table->integer('jop')->nullable();
            $table->integer('department')->nullable();
            $table->integer('joptybe')->nullable();
            $table->integer('joplevel')->nullable();
            $table->date('dateofhire')->nullable();
            $table->date('dateofend')->nullable();
            $table->integer('shift')->nullable();
            $table->integer('vacancy')->nullable();
            $table->integer('holiday')->nullable();
            $table->decimal('salary', 11, 2)->nullable();
            $table->string('password', 250)->nullable();
            $table->string('education', 100)->nullable();
            $table->string('skills', 200)->nullable();
            $table->decimal('hour_extra', 10, 2)->nullable()->default(0.00);
            $table->decimal('day_extra', 10, 2)->nullable()->default(0.00);
            $table->integer('ent_tybe')->nullable()->default(1);
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
        Schema::dropIfExists('employees');
    }
};
