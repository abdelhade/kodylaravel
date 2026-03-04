<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->boolean('allow_negative_stock')->default(1)->after('id');
        });
        
        // تفعيل البيع بمخزون سالب افتراضياً
        DB::table('settings')->where('id', 1)->update(['allow_negative_stock' => 1]);
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('allow_negative_stock');
        });
    }
};
