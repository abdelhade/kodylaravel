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
        Schema::create('chances', function (Blueprint $table) {
            $table->id();
            $table->string('client', 50)->nullable();
            $table->string('cname')->nullable();
            $table->string('phone', 20)->nullable();
            $table->date('cdate')->nullable();
            $table->boolean('important')->nullable();
            $table->decimal('expected', 10, 2)->nullable()->default(0);
            $table->integer('tybe')->nullable()->default(1);
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('chances');
    }
};
