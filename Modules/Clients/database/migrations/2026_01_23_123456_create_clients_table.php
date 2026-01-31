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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('phone2', 150)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('address2', 150)->nullable();
            $table->string('address3', 150)->nullable();
            $table->integer('city')->nullable();
            $table->decimal('height', 8, 2)->nullable();
            $table->decimal('weight', 8, 2)->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('ref', 20)->nullable();
            $table->string('diseses', 200)->nullable();
            $table->string('info', 200)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->string('imgs', 250)->nullable();
            $table->string('jop', 50)->nullable();
            $table->boolean('gender')->nullable();
            $table->string('drugs', 250)->nullable();
            $table->string('seriousdes', 250)->nullable();
            $table->string('familydes', 250)->nullable();
            $table->string('allergy', 250)->nullable();
            $table->string('temp', 9)->nullable();
            $table->string('pressure', 9)->nullable();
            $table->string('diabetes', 9)->nullable();
            $table->string('brate', 9)->nullable();
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
        Schema::dropIfExists('clients');
    }
};
