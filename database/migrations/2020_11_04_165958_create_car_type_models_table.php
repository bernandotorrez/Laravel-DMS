<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarTypeModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_type_model_porsche', function (Blueprint $table) {
            $table->bigIncrements('id_type_model');
            $table->foreignId('id_model')->references('id_model')->on('tbl_model_porsche')->onDelete('cascade');
            $table->string('type_model_name', 100);
            $table->softDeletes();
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
        Schema::dropIfExists('tbl_type_model_porsche');
    }
}
