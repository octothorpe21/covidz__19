<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWilayaUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wilaya_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('tag_id')->unsigned();
            $table->foreignId('wilaya_id')->unsigned();
            $table->foreign('wilaya_id')
              ->references('id')
              ->on('wilayas')
              ->onDelete('cascade');

            $table->foreign('idea_id')
              ->references('id')
              ->on('ideas')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wilaya_user');
    }
}
