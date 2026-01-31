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
        Schema::create('myvouchers', function (Blueprint $table) {
            $table->id();
            $table->date('vdate')->nullable();
            $table->integer('tybe')->nullable();
            $table->decimal('val', 10, 2)->nullable();
            $table->boolean('account')->nullable();
            $table->boolean('fund_account')->nullable();
            $table->string('voucher_id')->nullable();
            $table->string('serial_number', 20)->nullable();
            $table->boolean('cost_center')->nullable();
            $table->string('info', 200)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->integer('user')->nullable()->default(1);
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
        Schema::dropIfExists('myvouchers');
    }
};
