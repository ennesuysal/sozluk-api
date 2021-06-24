<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments("ID");
            $table->string('suser_id');
            $table->integer('entry_id')->unsigned();
            $table->integer("like");
            $table->timestamps();
            $table->foreign("suser_id")->references('nick')->on('susers')->onDelete('CASCADE');
            $table->foreign("entry_id")->references('ID')->on('entries')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
