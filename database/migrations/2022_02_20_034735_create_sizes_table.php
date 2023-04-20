<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::dropIfExists('product_sizes');
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sku',10)->nullable(true);
            $table->integer('product_id')->length(4)->nullable(false);
            $table->integer('size')->length(4)->nullable(false);
            $table->boolean('fixed_quantity')->default(false);
            $table->integer('quantity_left')->nullable(true);
            $table->integer('quantity_held')->nullable(true);
            $table->integer('quantity_left_warning_level')->nullable(true);
            $table->dateTime('deleted_at')->nullable(true);
        });

        Schema::table('product_catalog', function (Blueprint $table){
            $table->dropColumn('product_size_id');
            $table->dropColumn('sku');

            $table->dropColumn('fixed_quantity');
            $table->dropColumn('quantity_left');
            $table->dropColumn('quantity_held');
            $table->dropColumn('quantity_left_warning_level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sizes');
        Schema::dropIfExists('product_sizes');
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->nullable(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });
    }
}
