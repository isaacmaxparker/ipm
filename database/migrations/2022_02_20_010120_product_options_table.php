<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('product_options');

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option_type',60)->nullable(false);
            $table->string('option_display_name',60)->nullable(false);
            $table->string('option_value',60)->nullable(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });

        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(4)->nullable(false);
            $table->integer('option_id')->length(4)->nullable(false);
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
        Schema::dropIfExists('product_options');

        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(4)->nullable(false);
            $table->string('option_display_name',60)->nullable(false);
            $table->string('option_value',60)->nullable(true);
            $table->timestamps();
        });

        Schema::dropIfExists('options');

    }
}
