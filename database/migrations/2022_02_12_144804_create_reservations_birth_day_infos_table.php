<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsBirthDayInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations_birth_day_infos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rev_id')->nullable();
            $table->foreign('rev_id')->references('id')
                ->on('reservations')->onDelete('cascade');

            $table->string('name',500)->nullable();
            $table->string('email',500)->nullable();
            $table->string('phone',50)->nullable();
            $table->enum('gender',['male','female'])->nullable();
            $table->date('birthday')->nullable();

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
        Schema::dropIfExists('reservations_birth_day_infos');
    }
}
