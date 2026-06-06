<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('faculties', function (Blueprint $blueprint) {
            // Adds a nullable department column right after the designation column
            $blueprint->string('department')->nullable()->after('designation');
        });
    }

    public function down(): void
    {
        Schema::table('faculties', function (Blueprint $blueprint) {
            $blueprint->dropColumn('department');
        });
    }
};