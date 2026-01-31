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
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id();
            $table->boolean('journal_id')->nullable();
            $table->boolean('account_id')->nullable();
            $table->integer('debit')->nullable()->default(0);
            $table->integer('credit')->nullable()->default(0);
            $table->integer('tybe')->nullable();
            $table->string('info', 150)->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->integer('op2')->nullable()->default(0);
            $table->integer('op_id')->nullable()->default(0);
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('journal_entries');
    }
};
