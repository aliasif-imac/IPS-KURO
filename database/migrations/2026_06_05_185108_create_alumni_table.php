<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('graduation_year');
            $table->string('current_profession');
            $table->string('current_organization')->nullable();
            $table->string('city');
            $table->string('country')->default('Pakistan');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->text('testimonial')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
