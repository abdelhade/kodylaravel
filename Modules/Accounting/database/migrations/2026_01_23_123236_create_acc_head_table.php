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
        Schema::create('acc_head', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->integer('deletable')->nullable()->default(1);
            $table->boolean('editable')->nullable()->default(1);
            $table->string('aname')->nullable();
            $table->string('phone', 200)->nullable();
            $table->string('address', 200)->nullable();
            $table->string('e_mail', 100)->nullable();
            $table->integer('constant')->nullable()->default(0);
            $table->boolean('is_stock')->nullable()->default(0);
            $table->integer('is_fund')->nullable()->default(0);
            $table->integer('rentable')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('nature')->nullable();
            $table->integer('kind')->nullable();
            $table->boolean('is_basic')->nullable();
            $table->decimal('start_balance', 10, 2)->nullable()->default(0);
            $table->decimal('credit', 10, 2)->nullable()->default(0);
            $table->decimal('debit', 10, 2)->nullable()->default(0);
            $table->decimal('balance', 10, 2)->nullable()->default(0.000);
            $table->boolean('secret')->nullable()->default(0);
            $table->timestamp('crtime')->useCurrent();
            $table->timestamp('mdtime')->useCurrent()->useCurrentOnUpdate();
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
        Schema::dropIfExists('acc_head');
    }
};
