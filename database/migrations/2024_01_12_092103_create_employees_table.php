<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on(config('admin.database.users_table'));
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->foreignId('gender_id');
            $table->foreignId('id_type_id')->references('id')->on('id_types');
            $table->string('id_no')->nullable();
            $table->string('passport_no')->nullable();
            $table->date('dob');
            $table->string('email')->nullable();
            $table->string('primary_telephone')->nullable();
            $table->string('employee_number')->nullable();
            $table->foreignId('department_id');
            $table->foreignId('designation_id');
            $table->bigInteger('approver_id');

            $table->tinyInteger('is_approver')->nullable();
            $table->tinyInteger('is_booking_agent')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
