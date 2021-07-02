<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('heading')->nullable();
            $table->string('summary')->nullable();
            $table->string('vimeo_id')->nullable();
            $table->tinyInteger('ordinal');
            $table->bigInteger('lesson_id')->unsigned();
            $table->timestamps();

            $table->foreign('lesson_id')->references('id')
                        ->on('lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
