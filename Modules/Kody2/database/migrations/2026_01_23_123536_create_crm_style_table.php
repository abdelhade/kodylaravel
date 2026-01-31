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
        Schema::create('crm_style', function (Blueprint $table) {
            $table->id();
            $table->string('cname')->nullable();
            $table->string('info', 200)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->nullable()->useCurrent();
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
        Schema::dropIfExists('crm_style');
    }
};
