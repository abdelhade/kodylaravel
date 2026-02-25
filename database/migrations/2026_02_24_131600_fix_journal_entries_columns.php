<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // تعديل أنواع الأعمدة في journal_entries
        DB::statement('ALTER TABLE journal_entries MODIFY COLUMN journal_id INT(11) NULL');
        DB::statement('ALTER TABLE journal_entries MODIFY COLUMN account_id INT(11) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE journal_entries MODIFY COLUMN journal_id TINYINT(1) NULL');
        DB::statement('ALTER TABLE journal_entries MODIFY COLUMN account_id TINYINT(1) NULL');
    }
};
