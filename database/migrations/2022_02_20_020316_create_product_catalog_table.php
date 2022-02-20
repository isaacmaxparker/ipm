<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCatalogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('products');

        Schema::create('product_catalog', function (Blueprint $table) {
            $table->increments('id');
            $table->string('product_id',10)->nullable(true);
            $table->string('sku',10)->nullable(true);
            $table->string('product_color_id',60)->nullable(true);
            $table->string('secondary_color_id',60)->nullable(true);
            $table->string('product_size_id',60)->nullable(true);
            $table->boolean('fixed_quantity')->default(false);
            $table->integer('quantity_left')->nullable(true);
            $table->integer('quantity_held')->nullable(true);
            $table->integer('quantity_left_warning_level')->nullable(true);
            $table->boolean('available')->default(false);
            $table->integer('sort_order')->nullable(false)->default(0);
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type',15)->nullable(false);
            $table->string('name',60)->nullable(false);
            $table->decimal('price',8,2)->nullable(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_catalog');

        Schema::dropIfExists('products');
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
    }
}
