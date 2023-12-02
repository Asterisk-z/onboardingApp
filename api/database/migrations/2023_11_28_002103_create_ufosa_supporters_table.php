<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUfosaSupportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('ufosa_supporters'))
            return;
        Schema::create('ufosa_supporters', function (Blueprint $table) {
            $table->id();
            $table->string('nominee_email');
            $table->string('supporter_email');
            $table->string('supporter_uid');
            $table->string('supporting');
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
        Schema::dropIfExists('ufosa_supporters');
    }
}
