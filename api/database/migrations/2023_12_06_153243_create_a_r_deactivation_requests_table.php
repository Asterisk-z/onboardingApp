<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARDeactivationRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_r_deactivation_requests', function (Blueprint $table) {
            $table->id();

            $table->enum('approval_status', ['pending', 'approved', 'declined'])->default('pending')->comment('pending, approved, declined');

            $table->foreignId('ar_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('requester_user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('authoriser_id')->constrained('users')->onDelete('cascade');

            $table->enum('request_type', ['activate', 'deactivate']);

            $table->string('request_reason')->nullable();
            $table->string('approval_reason')->nullable();


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
        Schema::dropIfExists('a_r_deactivation_requests');
    }
}
