<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('category_id');
            $table->string('title');
            $table->text('body');
            $table->text('image')->nullable();
            $table->text('video')->nullable();
            $table->unsignedBigInteger('likes')->default(0);
            $table->boolean('liked')->default(0);
            $table->unsignedBigInteger('dislikes')->default(0);
            // 0 => pending, 1 => approved, 2 => refused
            $table->integer('status');
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
        Schema::dropIfExists('ideas');
    }
}
