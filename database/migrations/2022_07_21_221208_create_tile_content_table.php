<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTileContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tile_content', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tile_id')->nullable(false);
            $table->string('content_type',14)->nullable(false);
            $table->string('content_img',14)->nullable(true);
            $table->string('content_video',14)->nullable(true);
            $table->string('content_link',14)->nullable(true);
            $table->integer('sort_order')->nullable(true);
            $table->boolean('active');
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
        Schema::dropIfExists('tile_content');
    }
}
