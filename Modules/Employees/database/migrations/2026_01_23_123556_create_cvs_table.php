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
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();
            $table->boolean('userid')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->string('name')->nullable();
            $table->string('degree', 50)->nullable();
            $table->string('address', 100)->nullable();
            $table->date('birthdate')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('skills')->nullable();
            $table->string('exp1', 250)->nullable();
            $table->string('exp2', 250)->nullable();
            $table->string('exp3', 250)->nullable();
            $table->string('lastsalary')->nullable();
            $table->string('expsalary')->nullable()->default(0);
            $table->text('referances')->nullable();
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
        Schema::dropIfExists('cvs');
    }
};
