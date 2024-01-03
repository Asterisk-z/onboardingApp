<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropColumnStatusToFeesAndDues extends Migration
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
            $table->dropColumn('status');
            $table->dropColumn('file');
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
            $table->string('status')->unsigned();
            $table->string('file')->unsigned();
        });
    }
}
