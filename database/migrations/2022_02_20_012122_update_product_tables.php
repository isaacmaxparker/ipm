<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateProductTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('fixed_quantity')->default(false)->after('price');
            $table->integer('quantity_left')->nullable(true)->after('fixed_quantity');
            $table->integer('quantity_held')->nullable(true)->after('quantity_left');
            $table->integer('quantity_left_warning_level')->nullable(true)->after('quantity_held');

            $table->dropColumn('product_color');
            $table->dropColumn('design_color');

            $table->integer('product_color_id')->nullable(true)->after('name');
            $table->integer('secondary_color_id')->nullable(true)->after('product_color_id');
            $table->integer('product_size_id')->nullable(true)->after('secondary_color_id');
        });

        Schema::dropIfExists('product_options');
        Schema::dropIfExists('options');

        Schema::create('product_colors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->nullable(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });

        Schema::create('product_sizes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',60)->nullable(false);
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('fixed_quantity');
            $table->dropColumn('quantity_left');
            $table->dropColumn('quantity_held');
            $table->dropColumn('quantity_left_warning_level');
            $table->dropColumn('product_color_id');
            $table->dropColumn('secondary_color_id');
            $table->dropColumn('product_size_id');
        });

        Schema::dropIfExists('product_colors');

        Schema::dropIfExists('product_sizes');

        Schema::create('product_options', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->length(4)->nullable(false);
            $table->integer('option_id')->length(4)->nullable(false);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });

        Schema::table('product_options', function (Blueprint $table) {
            $table->boolean('fixed_quantity')->default(false)->after('option_id');
            $table->integer('quantity_left')->nullable(true)->after('fixed_quantity');
            $table->integer('quantity_held')->nullable(true)->after('quantity_left');
            $table->integer('quantity_left_warning_level')->nullable(true)->after('quantity_held');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->increments('id');
            $table->string('option_type',60)->nullable(false);
            $table->string('option_display_name',60)->nullable(false);
            $table->string('option_value',60)->nullable(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable(true);
        });
    }
}
