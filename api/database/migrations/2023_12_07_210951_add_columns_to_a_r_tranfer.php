<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToARTranfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('a_r_transfer_requests', function (Blueprint $table) {
            $table->enum('mbg_approval_status', ['pending', 'approved', 'declined'])->default('pending')->after('approval_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('a_r_transfer_requests', function (Blueprint $table) {
            //
        });
    }
}
