<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArCreationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ar_creation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_id')->constrained('fmdq_systems')->onDelete('cascade');
            $table->foreignId('submitted_by')->constrained('users')->onDelete('cascade');
            $table->string('next_office');
            $table->string('mbg_status')->default('Pending')->comment('Approve, Reject');
            $table->string('msg_status')->default('Pending')->comment('Approve, Reject');
            $table->string('status')->default('Pending')->comment('Treated, Rejected, Pending');
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
        Schema::dropIfExists('ar_creation_requests');
    }
}
