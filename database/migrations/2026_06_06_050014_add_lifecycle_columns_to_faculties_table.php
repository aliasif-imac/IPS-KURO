<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('faculties', function (Blueprint $table) {
            // Categorization
            $table->string('type')->default('teaching'); // teaching, administration, support, visiting
            
            // Status Control
            $table->string('lifecycle_status')->default('active'); // active, left
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('faculties', function (Blueprint $table) {
            $table->dropColumn(['type', 'lifecycle_status']);
        });
    }
};