<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement('ALTER TABLE reports MODIFY file LONGTEXT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE reports MODIFY file VARCHAR(255) NULL');
    }
};
