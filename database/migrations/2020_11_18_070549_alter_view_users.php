<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AlterViewUsers extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
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
            CREATE VIEW view_user
            AS
            SELECT u.id, u.name, u.email, u.no_hp, u.id_user_group,
            u.level, tug.user_group
            FROM users u
            INNER JOIN tbl_user_group tug ON tug.id_user_group = u.id_user_group
            WHERE u.deleted_at IS NULL;
        ";
    }

    private function dropView()
    {
        return "
            DROP VIEW IF EXISTS view_user;
        ";
    }
}
