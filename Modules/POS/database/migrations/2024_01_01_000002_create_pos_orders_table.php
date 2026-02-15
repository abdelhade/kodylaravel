<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول رؤوس الطلبات (إذا لم يكن موجوداً)
        if (!Schema::hasTable('ot_head')) {
            Schema::create('ot_head', function (Blueprint $table) {
                $table->id();
                $table->date('pro_date')->comment('تاريخ الطلب');
                $table->tinyInteger('pro_tybe')->default(9)->comment('نوع الطلب');
                $table->unsignedBigInteger('user')->comment('معرف المستخدم');
                $table->double('fat_total')->default(0)->comment('الإجمالي');
                $table->double('fat_disc')->default(0)->comment('الخصم');
                $table->double('fat_net')->default(0)->comment('الصافي');
                $table->text('info')->nullable()->comment('ملاحظات');
                $table->boolean('isdeleted')->default(false)->comment('علم الحذف');
                $table->timestamp('crtime')->useCurrent()->comment('وقت الإنشاء');
                $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate()->comment('وقت التعديل');
                $table->index('pro_date');
                $table->index('user');
                $table->index('pro_tybe');
            });
        }

        // جدول تفاصيل الطلبات (إذا لم يكن موجوداً)
        if (!Schema::hasTable('fat_details')) {
            Schema::create('fat_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('fat_id')->comment('معرف الطلب');
                $table->unsignedBigInteger('item_id')->comment('معرف الصنف');
                $table->double('quantity')->default(1)->comment('الكمية');
                $table->double('price')->default(0)->comment('السعر');
                $table->double('total')->default(0)->comment('الإجمالي');
                $table->timestamp('crtime')->useCurrent()->comment('وقت الإنشاء');
                $table->foreign('fat_id')->references('id')->on('ot_head')->onDelete('cascade');
                $table->index('fat_id');
                $table->index('item_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('fat_details');
        Schema::dropIfExists('ot_head');
    }
};
