<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductOptionsUpdate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('fixed_quantity');
            $table->dropColumn('quantity_left');
            $table->dropColumn('quantity_held');
            $table->dropColumn('quantity_left_warning_level');
        });

        Schema::table('product_options', function (Blueprint $table) {
            $table->boolean('fixed_quantity')->default(false)->after('option_id');
            $table->integer('quantity_left')->nullable(true)->after('fixed_quantity');
            $table->integer('quantity_held')->nullable(true)->after('quantity_left');
            $table->integer('quantity_left_warning_level')->nullable(true)->after('quantity_held');
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
            $table->boolean('fixed_quantity')->default(false);
            $table->integer('quantity_left')->nullable(true);
            $table->integer('quantity_held')->nullable(true);
            $table->integer('quantity_left_warning_level')->nullable(true);
        });

        Schema::table('product_options', function (Blueprint $table) {
            $table->dropColumn('fixed_quantity');
            $table->dropColumn('quantity_left');
            $table->dropColumn('quantity_held');
            $table->dropColumn('quantity_left_warning_level');
        });
    }
}
