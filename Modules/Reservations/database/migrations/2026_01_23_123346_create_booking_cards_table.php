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
        Schema::create('booking_cards', function (Blueprint $table) {
            $table->id();
            $table->string('client')->nullable();
            $table->string('barcode')->nullable();
            $table->string('rtybe')->nullable();
            $table->integer('rcost')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('remain')->nullable();
            $table->integer('bcase')->nullable();
            $table->date('fromdate')->nullable();
            $table->date('todate')->nullable();
            $table->datetime('crtime')->nullable()->useCurrent();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->integer('user')->nullable()->default(0);
            $table->boolean('bransh')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booking_cards');
    }
};
