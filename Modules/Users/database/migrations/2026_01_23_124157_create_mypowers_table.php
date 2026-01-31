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
        Schema::create('mypowers', function (Blueprint $table) {
            $table->id();
            $table->integer('power_id')->nullable();
            $table->integer('section_type_no')->nullable();
            $table->string('power_name', 100)->nullable();
            $table->string('eng_power_name', 100)->nullable();
            $table->integer('is_hide_in_casher')->nullable();
            $table->tinyInteger('level_no')->nullable();
            $table->tinyInteger('is_for_view_only')->nullable();
            $table->string('power_code', 100)->nullable();
            $table->tinyInteger('power_class')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('col_index')->nullable();
            $table->tinyInteger('stoped')->nullable();
            $table->tinyInteger('tmp_state_no')->nullable();
            $table->tinyInteger('power_type')->nullable();
            $table->tinyInteger('menu_type')->nullable();
            $table->string('def_state', 20)->nullable();
            $table->string('user_1', 20)->nullable();
            $table->string('kind', 10)->nullable();
            $table->tinyInteger('is_on_my_thread')->nullable();
            $table->tinyInteger('is_calling_from_main')->nullable();
            $table->string('calling_from', 10)->nullable();
            $table->tinyInteger('edit_mode')->nullable();
            $table->string('frist_shown_id', 10)->nullable();
            $table->tinyInteger('is_casher_from')->nullable();
            $table->tinyInteger('is_op_paper')->nullable();
            $table->tinyInteger('is_hiddin')->nullable();
            $table->tinyInteger('prog_id')->nullable();
            $table->tinyInteger('is_pure_kitchen')->nullable();
            $table->tinyInteger('is_for_api')->nullable();
            $table->timestamp('t_stamp')->nullable();
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
        Schema::dropIfExists('mypowers');
    }
};
