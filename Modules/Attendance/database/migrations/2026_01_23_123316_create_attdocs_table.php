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
        Schema::create('attdocs', function (Blueprint $table) {
            $table->id();
            $table->integer('empid')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
            $table->date('fromdate')->nullable();
            $table->date('todate')->nullable();
            $table->decimal('alldays', 10, 2)->nullable();
            $table->decimal('workdays', 10, 2)->nullable();
            $table->decimal('exphours', 10, 2)->nullable();
            $table->decimal('accualhours', 10, 2)->nullable();
            $table->integer('attdays')->nullable();
            $table->integer('absdays')->nullable();
            $table->integer('holidays')->nullable();
            $table->decimal('earlyminits', 10, 2)->nullable();
            $table->decimal('entitle', 10, 2)->nullable()->default(0);
            $table->string('info', 250)->nullable();
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
        Schema::dropIfExists('attdocs');
    }
};
