<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('paypal_order_id',34)->nullable(false);
            $table->string('transaction_id',34)->nullable(false);
            $table->string('customer_id',34)->nullable(false);
            $table->string('ship_address_1',34)->nullable(false);
            $table->string('ship_address_2',34)->nullable(false);
            $table->string('ship_city',34)->nullable(false);
            $table->string('ship_state',34)->nullable(false);
            $table->integer('ship_zip')->nullable(false);
            $table->string('ship_country',34)->nullable(false);
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->nullable(false);
            $table->integer('product_catalog_id')->nullable(false);
            $table->string('product_details',34)->nullable(false);
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name',34)->nullable(false);
            $table->string('last_name',34)->nullable(false);
            $table->string('email',54)->nullable(true);
            $table->string('phone',12)->nullable(true);
            $table->string('address_1',34)->nullable(false);
            $table->string('address_2',34)->nullable(false);
            $table->string('city',34)->nullable(false);
            $table->string('state',34)->nullable(false);
            $table->integer('zip')->nullable(false);
            $table->string('country',34)->nullable(false);
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('customers');
    }
}
