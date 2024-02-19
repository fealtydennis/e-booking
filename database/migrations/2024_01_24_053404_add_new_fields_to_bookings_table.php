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
        Schema::table('bookings', function (Blueprint $table) {
            //
//
            $table->string('fullname')->nullable();
            $table->foreignId('gender_id')->nullable();
            $table->foreignId('id_type_id')->nullable();
            $table->string('id_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('primary_telephone')->nullable();
            $table->string('employee_number')->nullable();
            $table->foreignId('department_id')->nullable();
            $table->foreignId('designation_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
