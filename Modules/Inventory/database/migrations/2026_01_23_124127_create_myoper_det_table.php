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
        Schema::create('myoper_det', function (Blueprint $table) {
            $table->id();
            $table->integer('oper_det_id')->nullable();
            $table->integer('int_oper_det_date')->nullable();
            $table->integer('oper_head_id')->nullable();
            $table->integer('comp_id')->nullable();
            $table->decimal('debit', 26, 4)->nullable();
            $table->decimal('credit', 26, 4)->nullable();
            $table->decimal('eng_debit', 26, 4)->nullable();
            $table->decimal('eng_credit', 26, 4)->nullable();
            $table->decimal('model_val', 26, 4)->nullable();
            $table->decimal('def_val', 26, 4)->nullable();
            $table->integer('acc_id')->nullable();
            $table->integer('stor_id')->nullable();
            $table->integer('group_id')->nullable();
            $table->integer('man_id')->nullable();
            $table->integer('cost_center_id')->nullable();
            $table->tinyInteger('has_costed_link')->nullable();
            $table->tinyInteger('is_not_active')->nullable();
            $table->string('notes', 50)->nullable();
            $table->string('mst_no', 20)->nullable();
            $table->string('mst_date', 12)->nullable();
            $table->decimal('balance_befor', 26, 4)->nullable();
            $table->decimal('balance_after', 26, 4)->nullable();
            $table->integer('det_Currency_id')->nullable();
            $table->decimal('det_Currency_unit_convert', 12, 6)->nullable();
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
        Schema::dropIfExists('myoper_det');
    }
};
