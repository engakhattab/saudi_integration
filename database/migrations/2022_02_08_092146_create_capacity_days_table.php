<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapacityDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capacity_days', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('count')->default(1250)->nullable();
            $table->enum('status',[0,1])->default(1)->nullable();

            $table->date('day');

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
        Schema::dropIfExists('capacity_days');
    }
}
