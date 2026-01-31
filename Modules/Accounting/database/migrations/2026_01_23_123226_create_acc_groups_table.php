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
        Schema::create('acc_groups', function (Blueprint $table) {
            $table->id();
            $table->string('aname')->nullable();
            $table->integer('acc_type')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->string('code', 30)->nullable();
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
        Schema::dropIfExists('acc_groups');
    }
};
