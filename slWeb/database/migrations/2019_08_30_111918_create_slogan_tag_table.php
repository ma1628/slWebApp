<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSloganTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slogan_tag', function (Blueprint $table) {
            $table->unsignedInteger('slogan_id');
            $table->unsignedInteger('tag_id');
            $table->primary(['slogan_id', 'tag_id']);
            $table->foreign('slogan_id')
                ->references('id')
                ->on('slogans')
                ->onDelete('cascade');
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('slogan_tag');
    }
}
