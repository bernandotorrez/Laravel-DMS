<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTypeColoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_type_colour_porsche', function (Blueprint $table) {
            $table->bigIncrements('id_type_colour');
            $table->foreignId('id_type_model')->references('id_type_model')->on('tbl_type_model_porsche')->onDelelete('cascade');
            $table->string('colour', 50);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_type_colour_porsche');
    }
}
