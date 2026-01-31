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
        Schema::create('myrents', function (Blueprint $table) {
            $table->id();
            $table->integer('cl_id')->nullable();
            $table->integer('rent_id')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('idintity', 50)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('pay_tybe')->nullable()->default(1);
            $table->decimal('r_value', 10, 2)->nullable()->default(0);
            $table->string('bnd1', 250)->nullable();
            $table->string('bnd2', 250)->nullable();
            $table->string('bnd3', 250)->nullable();
            $table->string('bnd4', 250)->nullable();
            $table->string('info', 250)->nullable();
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
        Schema::dropIfExists('myrents');
    }
};
