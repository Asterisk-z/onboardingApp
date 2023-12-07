<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_fields', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category')->constrained('membership_categories')->onDelete('cascade');
            $table->string('name')->unique(); //cac_certificate
            $table->string('description'); //CAC Certification
            $table->string('type')->comment('text, file, number, amount, date, email, phone');
            $table->tinyInteger('required')->default(0);
            $table->string('page');
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
        Schema::dropIfExists('application_fields');
    }
}
