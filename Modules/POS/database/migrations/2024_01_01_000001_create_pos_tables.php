<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // جدول الطاولات
        if (!Schema::hasTable('tables')) {
            Schema::create('tables', function (Blueprint $table) {
                $table->id();
                $table->string('tname')->comment('اسم الطاولة');
                $table->tinyInteger('table_case')->default(0)->comment('0=متاحة، 1=محجوزة، 2=صيانة');
                $table->timestamp('crtime')->useCurrent()->comment('وقت الإنشاء');
                $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate()->comment('وقت التعديل');
                $table->boolean('isdeleted')->default(false)->comment('علم الحذف المنطقي');
                $table->string('branch')->default('main')->comment('الفرع');
                $table->integer('tatnet')->default(0)->comment('حقل إضافي');
                $table->index('isdeleted');
                $table->index('table_case');
            });
        }

        // جدول الجلسات المغلقة
        if (!Schema::hasTable('closed_orders')) {
            Schema::create('closed_orders', function (Blueprint $table) {
                $table->id();
                $table->string('shift', 10)->comment('رقم الشيفت');
                $table->string('user', 10)->comment('اسم المستخدم');
                $table->date('date')->nullable()->comment('تاريخ الشيفت');
                $table->dateTime('strttime')->nullable()->comment('وقت البداية');
                $table->time('endtime')->nullable()->comment('وقت الانهاية');
                $table->double('total_sales')->default(0)->comment('إجمالي المبيعات');
                $table->double('delevery')->default(0)->comment('مبيعات الدليفري');
                $table->double('tables')->default(0)->comment('مبيعات الطاولات');
                $table->double('takeaway')->default(0)->comment('مبيعات التيك أواي');
                $table->double('expenses')->default(0)->comment('المصاريف');
                $table->double('fund_before')->default(0)->comment('رصيد الدرج قبل');
                $table->double('fund_after')->default(0)->comment('رصيد الدرج بعد');
                $table->string('exp_notes', 30)->nullable()->comment('ملاحظات المصاريف');
                $table->double('cash')->default(0)->comment('المبلغ المسلم');
                $table->string('info', 50)->nullable()->comment('ملاحظات');
                $table->timestamp('crtime')->useCurrent()->comment('وقت الإنشاء');
                $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate()->comment('وقت التعديل');
                $table->string('info2', 20)->comment('معلومات إضافية');
                $table->integer('tenant')->default(1)->comment('المستأجر');
                $table->integer('branch')->default(1)->comment('الفرع');
                $table->index('date');
                $table->index('user');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('closed_orders');
        Schema::dropIfExists('tables');
    }
};
