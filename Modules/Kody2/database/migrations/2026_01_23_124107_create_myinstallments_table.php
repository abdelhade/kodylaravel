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
        Schema::create('myinstallments', function (Blueprint $table) {
            $table->id();
            $table->integer('cl_id')->nullable();
            $table->integer('rent_id')->nullable();
            $table->integer('contract')->nullable()->default(0);
            $table->decimal('ins_value', 10, 2)->nullable()->default(0);
            $table->date('ins_date')->nullable();
            $table->integer('ins_case')->nullable();
            $table->decimal('ins_paid', 10, 2)->nullable();
            $table->integer('voucher')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->string('info', 250)->nullable();
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
        Schema::dropIfExists('myinstallments');
    }
};
