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
        Schema::create('pst_criminals', function (Blueprint $table) {
            $table->id();
            $table->string('cname')->nullable();
            $table->string('otherdetails', 200)->nullable();
            $table->boolean('karta')->nullable();
            $table->boolean('dngrs')->nullable();
            $table->boolean('fesh')->nullable();
            $table->string('prtnrs', 150)->nullable();
            $table->string('crmaddress', 150)->nullable();
            $table->string('idcardnum', 150)->nullable();
            $table->string('scar', 150)->nullable();
            $table->string('mname', 150)->nullable();
            $table->string('nickname', 150)->nullable();
            $table->string('tybe', 150)->nullable();
            $table->boolean('danger_factor')->nullable()->default(1);
            $table->string('info', 150)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('user')->nullable();
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
        Schema::dropIfExists('pst_criminals');
    }
};
