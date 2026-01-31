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
        Schema::create('myoptions', function (Blueprint $table) {
            $table->id();
            $table->string('oname')->nullable();
            $table->string('info', 250)->nullable();
            $table->integer('def_value')->nullable()->default(0);
            $table->integer('cur_value')->nullable()->default(0);
            $table->integer('op_tybe')->nullable()->default(0);
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
        Schema::dropIfExists('myoptions');
    }
};
