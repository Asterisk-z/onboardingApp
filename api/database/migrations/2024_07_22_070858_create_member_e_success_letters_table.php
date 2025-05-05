<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberESuccessLettersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_e_success_letters', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->unique();
            $table->string('designation');
            $table->text('address_line_one')->nullable();
            $table->text('address_line_two')->nullable();
            $table->text('address_line_three')->nullable();
            $table->string('companyName');
            $table->text('data')->nullable();
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
        Schema::dropIfExists('member_e_success_letters');
    }
}
