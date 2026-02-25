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
        Schema::table('ot_head', function (Blueprint $table) {
            // إضافة الأعمدة الناقصة للسندات
            if (!Schema::hasColumn('ot_head', 'pro_id')) {
                $table->integer('pro_id')->nullable()->after('id');
            }
            
            if (!Schema::hasColumn('ot_head', 'branch_id')) {
                $table->integer('branch_id')->nullable()->after('pro_id');
            }
            
            if (!Schema::hasColumn('ot_head', 'is_finance')) {
                $table->tinyInteger('is_finance')->default(0)->after('pro_tybe');
            }
            
            if (!Schema::hasColumn('ot_head', 'is_journal')) {
                $table->tinyInteger('is_journal')->default(0)->after('is_finance');
            }
            
            if (!Schema::hasColumn('ot_head', 'journal_tybe')) {
                $table->tinyInteger('journal_tybe')->nullable()->after('is_journal');
            }
            
            if (!Schema::hasColumn('ot_head', 'pro_num')) {
                $table->integer('pro_num')->nullable()->after('journal_tybe');
            }
            
            if (!Schema::hasColumn('ot_head', 'pro_value')) {
                $table->double('pro_value')->default(0)->after('fat_net');
            }
            
            if (!Schema::hasColumn('ot_head', 'cost_center')) {
                $table->integer('cost_center')->nullable()->after('pro_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ot_head', function (Blueprint $table) {
            $columns = [
                'pro_id',
                'branch_id',
                'is_finance',
                'is_journal',
                'journal_tybe',
                'pro_num',
                'pro_value',
                'cost_center'
            ];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('ot_head', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
