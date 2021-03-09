<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('title_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->text('entry');
            $table->timestamps();
            $table->foreign('title_id')->references('ID')->on('titles')->onDelete('CASCADE');
            $table->foreign('user_id')->references('id')->on('susers')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('entries');
    }
}
