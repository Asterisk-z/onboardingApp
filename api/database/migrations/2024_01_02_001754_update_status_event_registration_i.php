<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateStatusEventRegistrationI extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Registered', 'Declined'])->default('Pending')->after('event_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            //
        });
    }
}
