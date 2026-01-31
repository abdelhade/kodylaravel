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
        Schema::create('ot_head', function (Blueprint $table) {
            $table->id();
            $table->integer('pro_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('pro_tybe')->nullable();
            $table->integer('is_stock')->nullable();
            $table->integer('is_finance')->nullable();
            $table->integer('is_manager')->nullable();
            $table->integer('is_journal')->nullable();
            $table->integer('journal_tybe')->nullable();
            $table->string('info', 200)->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('pro_date')->nullable();
            $table->date('accural_date')->nullable();
            $table->integer('pro_pattren')->nullable();
            $table->string('pro_num', 50)->nullable();
            $table->string('pro_serial', 50)->nullable();
            $table->string('tax_num', 50)->nullable();
            $table->integer('price_list')->nullable();
            $table->integer('store_id')->nullable();
            $table->integer('emp_id')->nullable();
            $table->integer('emp2_id')->nullable();
            $table->integer('acc1')->nullable();
            $table->decimal('acc1_before', 10, 2)->nullable();
            $table->decimal('acc1_after', 10, 2)->nullable();
            $table->integer('acc2')->nullable();
            $table->decimal('acc2_before', 10, 2)->nullable();
            $table->decimal('acc2_after', 10, 2)->nullable();
            $table->decimal('pro_value', 10, 2)->nullable();
            $table->decimal('fat_cost', 10, 2)->nullable();
            $table->integer('cost_center')->nullable();
            $table->decimal('profit', 10, 2)->nullable();
            $table->decimal('fat_total', 10, 2)->nullable();
            $table->decimal('fat_net', 10, 2)->nullable()->default(0);
            $table->decimal('fat_disc', 10, 2)->nullable();
            $table->decimal('fat_disc_per', 10, 2)->nullable();
            $table->decimal('fat_plus', 10, 2)->nullable();
            $table->decimal('fat_plus_per', 10, 2)->nullable();
            $table->decimal('fat_tax', 10, 2)->nullable();
            $table->decimal('fat_tax_per', 10, 2)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->boolean('acc_fund')->nullable()->default(0);
            $table->integer('op2')->nullable()->default(0);
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('user')->nullable()->default(1);
            $table->integer('tenant')->nullable()->default(0);
            $table->integer('branch')->nullable()->default(0);
            $table->boolean('closed')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ot_head');
    }
};
