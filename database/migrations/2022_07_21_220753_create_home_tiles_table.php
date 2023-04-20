<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHomeTilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_tiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('headline',34)->nullable(false);
            $table->string('subheading',434)->nullable(true);
            $table->string('description',34)->nullable(true);
            $table->string('content_type',14)->nullable(false);
            $table->string('tile_back_img',14)->nullable(false);
            $table->string('tile_link',34)->nullable(true);
            $table->integer('sort_order')->nullable(true);
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
        Schema::dropIfExists('home_tiles');
    }
}
