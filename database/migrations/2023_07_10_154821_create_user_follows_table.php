<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_follows', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('follows_user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('follows_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->primary(['user_id', 'follows_user_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_follows');
    }
};
