<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationFieldApplicationFieldUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_field_application_field_uploads', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id');
            $table->integer('application_field_id');
            $table->integer('application_field_upload_id');
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
        Schema::dropIfExists('application_field_application_field_uploads');
    }
}
