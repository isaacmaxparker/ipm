<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSongReleasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('song_releases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('release_id')->length(4)->nullable(false);
            $table->integer('song_id')->length(4)->nullable(false);
            $table->timestamps();
        });

        Schema::table('songs', function (Blueprint $table) {
            $table->dropColumn('release_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('song_releases');
        
        Schema::table('songs', function (Blueprint $table) {
            $table->integer('release_id')->length(4);
        });
    }
}
