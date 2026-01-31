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
        Schema::create('my_news', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('img', 250)->nullable();
            $table->string('tags', 250)->nullable();
            $table->text('content')->nullable();
            $table->integer('user')->nullable()->default(1);
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
        Schema::dropIfExists('my_news');
    }
};
