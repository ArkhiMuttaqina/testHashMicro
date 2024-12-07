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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_title_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('birth_place_id')->nullable();
            $table->unsignedBigInteger('employee_number')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('birth_place', 35)->nullable();
            $table->string('sex', 2)->nullable()->comment("M = LAKI LAKI, F = PEREMPUAN");
            $table->datetime('birth_date')->nullable();
            $table->string('status_employee', 22)->nullable()->comment('tetap, kontrak');
            $table->string('status', 10)->nullable()->comment('ACTIVE, INACTIVE, DELETED');
            $table->datetime('join_date')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('birth_place_id')->references('id')->on('cities');

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
