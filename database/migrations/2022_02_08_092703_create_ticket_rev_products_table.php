<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketRevProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_rev_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rev_id')->nullable();
            $table->foreign('rev_id')->references('id')
                ->on('reservations')->onDelete('cascade');

            $table->unsignedBigInteger('ticket_id')->nullable();
            $table->foreign('ticket_id')->references('id')
                ->on('tickets')->onDelete('cascade');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')
                ->on('categories')->onDelete('cascade');

            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')
                ->on('products')->onDelete('cascade');

            $table->double('qty')->default(0)->nullable();
            $table->double('price')->default(0)->nullable();
            $table->double('total_price')->default(0)->nullable();



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
        Schema::dropIfExists('ticket_rev_products');
    }
}
