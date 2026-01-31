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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->string('subject')->nullable();
            $table->boolean('call_type')->nullable()->default(1);
            $table->date('call_date')->nullable();
            $table->time('call_time')->nullable();
            $table->string('duration', 100)->nullable();
            $table->integer('client_id')->nullable()->default(1);
            $table->string('emp_comment', 250)->nullable();
            $table->text('content')->nullable();
            $table->date('next_date')->nullable();
            $table->time('next_time')->nullable();
            $table->string('mod_comment', 250)->nullable();
            $table->boolean('mod_rate')->nullable()->default(5);
            $table->integer('user_id')->nullable()->default(1);
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
        Schema::dropIfExists('calls');
    }
};
