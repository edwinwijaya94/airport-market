<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->text('product_img');
            $table->string('product_name');
            $table->integer('quantity');
            $table->integer('unit_id');
            $table->string('unit_name');
            $table->integer('price_min');
            $table->integer('price_max');
            $table->boolean('is_priority');
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
        Schema::dropIfExists('carts');
    }
}
