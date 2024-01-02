<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIsDelToFeesAndDues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fees_and_dues', function (Blueprint $table) {
            //
            $table->tinyInteger('is_del')->default(0)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fees_and_dues', function (Blueprint $table) {
            //
            $table->dropColumn('is_del');
        });
    }
}