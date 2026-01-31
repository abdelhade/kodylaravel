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
        Schema::create('criminals', function (Blueprint $table) {
            $table->id();
            $table->string('cname')->nullable();
            $table->string('nickname')->nullable();
            $table->date('dateofbirth')->nullable();
            $table->string('jop')->nullable();
            $table->string('station', 111)->nullable();
            $table->string('mname')->nullable();
            $table->string('crmaddress')->nullable();
            $table->string('idcardnum')->nullable();
            $table->integer('scar')->nullable();
            $table->string('otherdetails')->nullable();
            $table->string('prtnrs')->nullable();
            $table->integer('crmstyle')->nullable();
            $table->integer('dngrs')->nullable();
            $table->integer('fesh')->nullable();
            $table->integer('karta')->nullable();
            $table->integer('entry')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->nullable()->useCurrent();
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
        Schema::dropIfExists('criminals');
    }
};
