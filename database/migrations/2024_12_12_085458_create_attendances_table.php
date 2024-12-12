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
        Schema::create('attendances', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('attendance_date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->string('status_check_in')->nullable()->comment('Present, Late, Absent');
            $table->string('status_check_out')->nullable()->comment('Go home early, Over Time, Absent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
