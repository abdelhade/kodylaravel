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
            // حقل لتتبع حالة التحويل
            $table->tinyInteger('converted_to_invoice')->default(0)->after('isdeleted')->comment('1 = تم التحويل لفاتورة');
            
            // حقل لتاريخ التحويل
            $table->timestamp('converted_at')->nullable()->after('converted_to_invoice')->comment('تاريخ التحويل');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ot_head', function (Blueprint $table) {
            $table->dropColumn(['converted_to_invoice', 'converted_at']);
        });
    }
};
