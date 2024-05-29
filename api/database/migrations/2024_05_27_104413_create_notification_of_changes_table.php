<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationOfChangesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_of_changes', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('summary');
            $table->enum('regulatory_status', ['yes', 'no'])->default('no');
            $table->string('regulatory_approval')->nullable();
            $table->enum('confidentiality_level', ['high', 'medium', 'low']);
            $table->string('attachment')->nullable();
            $table->enum('ar_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('meg_status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('institution_id');
            $table->integer('ar_authoriser_id');
            $table->text('meg_subject')->nullable();
            $table->text('meg_summary')->nullable();
            $table->text('meg_document')->nullable();
            $table->text('stakeholders')->nullable();
            $table->integer('created_by');
            $table->string('status_reason')->nullable();
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
        Schema::dropIfExists('notification_of_changes');
    }
}
