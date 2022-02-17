<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',15)->nullable(false);
            $table->string('sku',10)->nullable(true);
            $table->string('name',60)->nullable(false);
            $table->string('product_color',60)->nullable(true);
            $table->string('design_color',60)->nullable(true);
            $table->decimal('price',8,2)->nullable(false);
            $table->boolean('fixed_quantity')->default(false);
            $table->integer('quantity_left')->nullable(true);
            $table->integer('quantity_held')->nullable(true);
            $table->integer('quantity_left_warning_level')->nullable(true);
            $table->boolean('available')->default(false);
            $table->integer('sort_order')->nullable(false)->default(0);
            $table->timestamps();
        });

        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(4)->nullable(false);
            $table->string('option_display_name',60)->nullable(false);
            $table->string('option_value',60)->nullable(true);
            $table->timestamps();
        });

        Schema::create('featured_products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(4)->nullable(false);
            $table->integer('rank_order')->length(4)->nullable(false)->default(0);
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
        Schema::dropIfExists('product_options');
        Schema::dropIfExists('featured_products');
    }
}
