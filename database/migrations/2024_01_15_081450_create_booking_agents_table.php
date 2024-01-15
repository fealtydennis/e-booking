<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_agents', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('ticket')->nullable();
            $table->string('ticket_number')->nullable();
            $table->string('airline')->nullable();
            $table->foreignId('destination_id')->references('id')->on('destinations');
            $table->foreignId('departure_id')->references('id')->on('destinations');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('invoice_number')->nullable();
            $table->string('Mode of Payment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_agents');
    }
}
