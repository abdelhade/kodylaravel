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
        // التحقق من وجود العمود قبل الإضافة
        if (!Schema::hasColumn('ot_head', 'accural_date')) {
            Schema::table('ot_head', function (Blueprint $table) {
                $table->date('accural_date')->nullable()->after('pro_date')->comment('تاريخ الاستحقاق');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ot_head', function (Blueprint $table) {
            if (Schema::hasColumn('ot_head', 'accural_date')) {
                $table->dropColumn('accural_date');
            }
        });
    }
};
