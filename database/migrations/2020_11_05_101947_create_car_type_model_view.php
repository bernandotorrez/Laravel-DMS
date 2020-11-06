<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCarTypeModelView extends Migration
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
                CREATE VIEW view_type_model_porsche
                AS
                SELECT ttmp.id_type_model, ttmp.type_model_name, ttmp.id_model, tmp.model_name
                FROM tbl_type_model_porsche ttmp
                INNER JOIN tbl_model_porsche tmp ON ttmp.id_model = tmp.id_model
                WHERE ttmp.deleted_at IS NULL
                ";
    }

    private function dropView()
    {
        return "
            DROP VIEW IF EXISTS view_type_model_porsche;
            ";
    }
}
