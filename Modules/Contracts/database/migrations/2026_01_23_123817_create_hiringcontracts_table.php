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
        Schema::create('hiringcontracts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('employee')->nullable();
            $table->integer('jop')->nullable();
            $table->string('jopdescription', 250)->nullable();
            $table->text('joprule1')->nullable();
            $table->text('joprule2')->nullable();
            $table->text('joprule3')->nullable();
            $table->text('joprule4')->nullable();
            $table->integer('workhours')->nullable();
            $table->integer('inorderhours')->nullable();
            $table->integer('workdaysoff')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('salaryraise')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->integer('user')->nullable();
            $table->string('info', 250)->nullable();
            $table->date('startcontract')->nullable();
            $table->date('endcontract')->nullable();
            $table->integer('type')->nullable();
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
        Schema::dropIfExists('hiringcontracts');
    }
};
