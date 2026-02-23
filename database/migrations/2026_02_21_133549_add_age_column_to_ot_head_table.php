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
            // إضافة عمود age لحفظ نوع الطلب (1=تيك أواي، 2=طاولة، 3=دليفري)
            $table->tinyInteger('age')->default(1)->after('pro_tybe')->comment('نوع الطلب: 1=تيك أواي، 2=طاولة، 3=دليفري');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ot_head', function (Blueprint $table) {
            $table->dropColumn('age');
        });
    }
};
