<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // Avoid failing migrations on environments where the table already exists partially.
            $table->string('employee_code', 80);
            $table->string('full_name', 255);

            // Re-add uniqueness explicitly.
            $table->unique('employee_code', 'employees_employee_code_unique');


            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nationality', 120)->nullable();
            $table->boolean('disability_status')->default(false);

            $table->string('phone_number', 40)->nullable();
            $table->string('email', 190)->nullable()->unique();
            $table->string('address', 255)->nullable();

            $table->string('department', 120)->nullable();
            $table->string('position', 120)->nullable();

            $table->string('employment_type', 50)->nullable();
            $table->date('hire_date')->nullable();
            $table->string('work_location', 120)->nullable();

            $table->string('status', 30)->default('Active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

