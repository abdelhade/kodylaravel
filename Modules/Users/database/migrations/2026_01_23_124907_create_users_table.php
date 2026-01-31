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
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uname')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('crtime')->useCurrent();
            $table->boolean('isdeleted')->nullable()->default(0);
            $table->integer('usertype')->nullable();
            $table->integer('userrole')->nullable()->default(1);
            $table->string('img')->nullable();
            $table->integer('def_client')->nullable();
            $table->integer('def_fund')->nullable();
            $table->integer('def_store')->nullable();
            $table->integer('def_prod')->nullable();
            $table->integer('def_emp')->nullable();
            $table->integer('tasksindex')->nullable();
            $table->integer('tasksadd')->nullable();
            $table->integer('tasksedit')->nullable();
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
        Schema::dropIfExists('users');
    }
};
