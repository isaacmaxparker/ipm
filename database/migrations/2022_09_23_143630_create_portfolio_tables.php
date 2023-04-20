<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortfolioTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->length(2)->nullable(false);
            $table->string('title',24)->nullable(false);
            $table->string('description',24)->nullable(false);
            $table->string('price',24)->nullable(false);
            $table->dateTime('deleted_at')->nullable(true);
        });

        Schema::create('portfolio_assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type_id',10)->nullable(false);
            $table->string('role',10)->nullable(false);
            $table->integer('asset_link')->length(4)->nullable(false);
            $table->string('description',24)->nullable(true);
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
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('portfolio_assets');
    }
}
