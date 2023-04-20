<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('releases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',60)->nullable(false);
            $table->string('subtitle',60);
            $table->date('release_date')->nullable(false);
            $table->string('img_link',256);
            $table->string('back_img_link',256);
            $table->string('theme_color',60)->nullable(false)->defualt('white');
            $table->string('youtube_link',256);
            $table->string('spotify_link',256);
            $table->string('itunes_link',256);
            $table->string('amazon_link',256);
            $table->string('iheartradio_link',256);
            $table->string('distrokid_link',256);
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
        Schema::dropIfExists('releases');
    }
}
