<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketRevModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_rev_models', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rev_id')->nullable();
            $table->foreign('rev_id')->references('id')
                ->on('reservations')->onDelete('cascade');


            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')
                ->on('tickets')->onDelete('cascade');

            $table->string('coupon_num')->comment('will be null if there is no coupon of this model')->nullable();


            $table->unsignedBigInteger('visitor_type_id')->nullable();
            $table->foreign('visitor_type_id')->references('id')
                ->on('visitor_types')->onDelete('cascade');

            $table->double('price')->default(0)->nullable();

            $table->string('bracelet_number',50)->nullable();
            $table->string('name',500)->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender',['male','female'])->nullable();

            $table->enum('status',['append','in','out'])->default('append')->nullable();

            $table->double('top_up_hours')->default(0)->nullable();
            $table->double('top_up_price')->default(0)->nullable();

            $table->time('shift_start')->nullable();
            $table->time('shift_end')->nullable();

            $table->time('start_at')->nullable();
            $table->time('end_at')->nullable();

            $table->enum('temp_status',['in','out'])->default('in')->nullable();


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
        Schema::dropIfExists('ticket_rev_models');
    }
}
