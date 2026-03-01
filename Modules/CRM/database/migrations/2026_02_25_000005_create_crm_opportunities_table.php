<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_opportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('lead_id')->constrained('crm_leads')->onDelete('cascade');
            $table->foreignId('stage_id')->constrained('crm_opportunity_stages')->onDelete('cascade');
            $table->decimal('amount', 15, 2)->default(0);
            $table->integer('probability')->default(0);
            $table->date('expected_close_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_opportunities');
    }
};
