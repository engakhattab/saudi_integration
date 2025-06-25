<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->enum('gender',['male','female'])->nullable();

            $table->unsignedBigInteger('giv_id')->nullable();
            $table->foreign('giv_id')->references('id')
                ->on('governorates')->onDelete('cascade');

            $table->unsignedBigInteger('city_id')->nullable();
            $table->foreign('city_id')->references('id')
                ->on('cities')->onDelete('cascade');


            $table->unsignedBigInteger('ref_id')->comment('المرجعى')->nullable();
            $table->foreign('ref_id')->references('id')
                ->on('references')->onDelete('set null');

            $table->integer('family_size')->default(0)->nullable();

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
        Schema::dropIfExists('clients');
    }
}
