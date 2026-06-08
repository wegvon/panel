<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('services')->update(['label' => null]);
    }

    public function down(): void
    {
        // No reverse — labels were stale WHMCS import values
    }
};
