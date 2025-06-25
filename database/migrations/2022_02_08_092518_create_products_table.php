<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title',500)->nullable();

            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')
                ->on('categories')->onDelete('cascade');

            $table->enum('status',[0,1])->default(1)->nullable();

            $table->double('price')->nullable()->default(0);

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
        Schema::dropIfExists('products');
    }
}
