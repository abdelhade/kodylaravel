<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_activities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('type_id')->constrained('crm_activity_types')->onDelete('cascade');
            $table->string('related_to');
            $table->unsignedBigInteger('related_id');
            $table->dateTime('activity_date');
            $table->integer('duration')->default(0);
            $table->text('description')->nullable();
            $table->enum('status', ['planned', 'completed', 'cancelled'])->default('planned');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_activities');
    }
};
