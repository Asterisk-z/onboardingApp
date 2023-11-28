<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUfosaNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ufosa_nominees', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('position');
            $table->string('grad_year');
            $table->string('surname');
            $table->string('first_name');
            $table->string('address');
            $table->date('dob')->nullable();
            $table->string('city')->nullable();
            $table->string('state');
            $table->string('gender')->nullable();
            $table->string('phone')->nullable();
            $table->string('year1');
            $table->string('nom1');
            $table->string('year2');
            $table->string('nom2');
            $table->string('year3');
            $table->string('nom3');
            $table->string('year4');
            $table->string('nom4');
            $table->string('year5');
            $table->string('nom5');
            $table->string('year6');
            $table->string('nom6')->nullable();
            $table->string('year7')->nullable();
            $table->string('nom7')->nullable();
            $table->string('year8')->nullable();
            $table->string('nom8')->nullable();
            $table->string('year9')->nullable();
            $table->string('nom9')->nullable();
            $table->string('year10')->nullable();
            $table->string('nom10')->nullable();
            $table->string('emp_status');
            $table->string('industry');
            $table->string('employer1');
            $table->string('emp_email1');
            $table->string('emp_phone1');
            $table->date('emp_date1');
            $table->string('employer2')->nullable();
            $table->string('emp_email2')->nullable();
            $table->string('emp_phone2')->nullable();
            $table->date('emp_date2')->nullable();
            $table->string('employer3')->nullable();
            $table->string('emp_email3')->nullable();
            $table->string('emp_phone3')->nullable();
            $table->date('emp_date3')->nullable();
            $table->string('academic');
            $table->string('institution')->nullable();
            $table->string('acad_year')->nullable();
            $table->string('assoc1')->nullable();
            $table->date('assoc_join1')->nullable();
            $table->string('assoc_role1')->nullable();
            $table->string('assoc2')->nullable();
            $table->date('assoc_join2')->nullable();
            $table->string('assoc_role2')->nullable();
            $table->string('assoc3')->nullable();
            $table->date('assoc_join3')->nullable();
            $table->string('assoc_role3')->nullable();
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
        Schema::dropIfExists('ufosa_nominees');
    }
}
