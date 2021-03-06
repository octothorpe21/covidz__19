<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('fname');
            $table->string('lname');
            $table->string('bio')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();            
            $table->boolean('isActivated')->default(0);
            // 0 for user and 1 for admin
            $table->boolean('role')->default(0);
            $table->foreignId('wilaya_id')->nullable();
            $table->foreignId('job_id')->nullable();
            $table->foreignId('disease_id')->nullable();
            // 0 => Male , 1 => female
            $table->boolean('gender')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('avatar')->nullable();
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
        Schema::dropIfExists('users');
    }
}
