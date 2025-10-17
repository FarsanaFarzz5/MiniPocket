<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Add a nullable 'source' column after 'type'
            $table->string('source')->nullable()->after('type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop the column if we rollback
            $table->dropColumn('source');
        });
    }
};
