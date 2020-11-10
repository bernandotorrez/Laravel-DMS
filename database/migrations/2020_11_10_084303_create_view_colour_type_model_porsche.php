<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewColourTypeModelPorsche extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function createView()
    {
        return "
            CREATE VIEW view_colour_type_model_porsche
            AS
            SELECT ttcp.id_type_colour, ttcp.id_type_model, ttmp.id_model,
            ttcp.colour, ttmp.type_model_name, tmp.model_name
            FROM tbl_type_colour_porsche ttcp
            INNER JOIN tbl_type_model_porsche ttmp ON ttmp.id_type_model = ttcp.id_type_model
            INNER JOIN tbl_model_porsche tmp ON tmp.id_model = ttmp.id_model 
            WHERE ttcp.deleted_at IS NULL;
        ";
    }

    private function dropView()
    {
        return "
            DROP VIEW IF EXISTS view_colour_type_model_porsche;
        ";
    }
}
