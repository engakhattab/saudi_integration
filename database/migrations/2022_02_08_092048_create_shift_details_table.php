<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShiftDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')
                ->on('shifts')->onDelete('set null');

            $table->unsignedBigInteger('visitor_type_id')->nullable();
            $table->foreign('visitor_type_id')->references('id')
                ->on('visitor_types')->onDelete('set null');

            $table->double('price')->default(0)->nullable();

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
        Schema::dropIfExists('shift_details');
    }
}
