<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArsToBeCreatedOnSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ars_to_be_created_on_systems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ar_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('ar_creation_request_id')->constrained('ar_creation_requests')->onDelete('cascade');
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
        Schema::dropIfExists('ars_to_be_created_on_systems');
    }
}
