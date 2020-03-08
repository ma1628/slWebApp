<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlogansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slogans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phrase',255);
            $table->string('writer',255)->nullable();
            $table->string('source',255);
            $table->decimal('rating',2,1);
            $table->text('supplement')->nullable();
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
        Schema::dropIfExists('slogans');
    }
}
