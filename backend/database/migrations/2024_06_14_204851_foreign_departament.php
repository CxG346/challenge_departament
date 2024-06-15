<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignDepartament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departament', function (Blueprint $table) {
            $table->foreign('ambassador')->references('id')->on('employee')->after('departament_dad_id');
            $table->foreign('departament_dad_id')->references('id')->on('departament')->after('ambassador');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('departament', function (Blueprint $table) {
            $table->dropForeign(['ambassador']);
            $table->dropForeign(['departament_dad_id']);
        });
    }
}
