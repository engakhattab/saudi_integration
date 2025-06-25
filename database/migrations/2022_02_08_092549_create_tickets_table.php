<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            //////////// Cashier ////////////////////
            $table->integer('add_by');


            $table->date('visit_date')->nullable();

            $table->unsignedBigInteger('shift_id')->nullable();
            $table->foreign('shift_id')->references('id')
                ->on('shifts')->onDelete('cascade');

            $table->unsignedBigInteger('client_id')->nullable();
            $table->foreign('client_id')->references('id')
                ->on('clients')->onDelete('cascade');

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
        Schema::dropIfExists('tickets');
    }
}
