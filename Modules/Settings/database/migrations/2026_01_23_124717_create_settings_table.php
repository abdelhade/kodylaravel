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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 200)->nullable();
            $table->string('company_add', 200)->nullable();
            $table->string('company_email', 50)->nullable();
            $table->string('company_tel', 200)->nullable();
            $table->string('edit_pass', 50)->nullable();
            $table->string('lic', 250)->nullable();
            $table->text('updateline')->nullable();
            $table->integer('acc_rent')->nullable()->default(0);
            $table->date('startdate')->nullable();
            $table->date('enddate')->nullable();
            $table->string('lang', 20)->nullable()->default('ar');
            $table->string('bodycolor', 50)->nullable();
            $table->boolean('showhr')->nullable()->default(1);
            $table->boolean('showclinc')->nullable()->default(1);
            $table->integer('showatt')->nullable()->default(1);
            $table->integer('showpayroll')->nullable()->default(1);
            $table->integer('showrent')->nullable()->default(1);
            $table->integer('showpay')->nullable()->default(1);
            $table->integer('showtsk')->nullable()->default(1);
            $table->integer('def_pos_client')->nullable();
            $table->integer('def_pos_store')->nullable();
            $table->integer('def_pos_employee')->nullable();
            $table->integer('def_pos_fund')->nullable();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->integer('tenant')->nullable()->default(0);
            $table->integer('branch')->nullable()->default(0);
            $table->string('logo', 255)->nullable();
            $table->boolean('show_all_tasks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
