<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            //////////// Cashier ////////////////////
            $table->integer('add_by');

            //////////// client ////////////////////
            $table->string('client_name',500)->nullable();
            $table->string('phone',500)->nullable();
            $table->string('email',500)->nullable();
            $table->enum('gender',['male','female'])->nullable();

            $table->unsignedBigInteger('giv_id')->nullable();
            $table->foreign('giv_id')->references('id')
                ->on('governorates')->onDelete('cascade');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->onDelete('cascade');
            ///////////////////// end client //////////////////


            $table->unsignedBigInteger('event_id')->nullable();
            $table->foreign('event_id')->references('id')
                ->on('events')->onDelete('cascade');


            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')
                ->on('shifts')->onDelete('cascade');

            $table->double('hours_count')->default(0)->nullable();
            $table->double('total_price')->default(0)->nullable();

            $table->double('total_top_up_hours')->default(0)->nullable();
            $table->double('total_top_up_price')->default(0)->nullable();

            $table->enum('payment_status',[0,1])->default(0)->nullable();

            $table->text('note')->nullable();

            $table->enum('discount_type',['per','val'])->default('val')->nullable();
            $table->double('discount_value')->default(0)->nullable();


            $table->double('grand_total')->default(0)->nullable();

            $table->double('paid_amount')->comment('المدفوع')->default(0)->nullable();
            $table->double('rem_amount')->comment('المتبقى')->default(0)->nullable();


            $table->enum('status',['append','in','out'])->default('append')->nullable();

            $table->enum('is_coupon',['0','1'])->comment('1 means it is coupon')->default(0)->nullable();
            $table->date('coupon_start')->default(null);
            $table->date('coupon_end')->default(null);

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
        Schema::dropIfExists('reservations');
    }
}
