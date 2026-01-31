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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('n1', 100)->nullable()->default(0);
            $table->string('n2', 100)->nullable()->default(0);
            $table->string('n3', 100)->nullable()->default(0);
            $table->string('n4', 100)->nullable()->default(0);
            $table->string('n5', 100)->nullable()->default(0);
            $table->string('n6', 100)->nullable()->default(0);
            $table->string('n7', 100)->nullable()->default(0);
            $table->string('n8', 100)->nullable()->default(0);
            $table->string('n9', 100)->nullable()->default(0);
            $table->string('n10', 100)->nullable()->default(0);
            $table->string('n11', 100)->nullable()->default(0);
            $table->string('n12', 100)->nullable()->default(0);
            $table->string('n13', 100)->nullable()->default(0);
            $table->string('n14', 100)->nullable()->default(0);
            $table->string('n15', 100)->nullable()->default(0);
            $table->string('n16', 100)->nullable()->default(0);
            $table->string('n17', 100)->nullable()->default(0);
            $table->string('n18', 100)->nullable()->default(0);
            $table->string('n19', 100)->nullable()->default(0);
            $table->timestamp('crtime')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
