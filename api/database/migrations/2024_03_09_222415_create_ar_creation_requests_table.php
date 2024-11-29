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
            $table->enum('mbg_status', ['Treated', 'Rejected', 'Pending'])->default('Pending');
            $table->enum('msg_status', ['Treated', 'Rejected', 'Pending'])->default('Pending');
            $table->enum('status', ['Treated', 'Rejected', 'Pending'])->default('Pending');
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
