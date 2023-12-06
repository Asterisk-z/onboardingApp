<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUfosaSupporterBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('ufosa_supporter_backups'))
            return;
        Schema::create('ufosa_supporter_backups', function (Blueprint $table) {
            $table->string('nominee_email');
            $table->string('supporter_email');
            $table->string('supporter_uid');
            $table->string('supporting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ufosa_supporter_backups');
    }
}
