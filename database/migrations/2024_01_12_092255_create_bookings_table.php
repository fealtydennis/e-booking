<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id');
            $table->text('reason')->nullable();
            $table->string('status')->default('pending')->nullable();
            $table->foreignId('departure_id')->references('id')->on('destinations');
            $table->foreignId('destination_id');
            $table->bigInteger('total_days');
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('initiated_by')->references('id')->on(config('admin.database.users_table'));
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
        Schema::dropIfExists('bookings');
    }
}
