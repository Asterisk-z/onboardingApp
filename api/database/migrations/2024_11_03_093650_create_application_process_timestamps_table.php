<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationProcessTimestampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_process_timestamps', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->unique();
            $table->timestamp('applicant_completed_application')->nullable();
            $table->timestamp('mbg_completed_concession')->nullable();
            $table->timestamp('applicant_made_payment')->nullable();
            $table->timestamp('fsd_validated_payment')->nullable();
            $table->timestamp('mbg_approve_payment')->nullable();
            $table->timestamp('meg_review_application_document')->nullable();
            $table->timestamp('meg2_approve_application_document')->nullable();
            $table->timestamp('meg_send_agreement_to_applicant')->nullable();
            $table->timestamp('applicant_upload_agreement')->nullable();
            $table->timestamp('applicant_added_all_ar')->nullable();
            $table->timestamp('meg_upload_signed_agreement')->nullable();
            $table->timestamp('meg2_send_esuccess_letter')->nullable();
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
        Schema::dropIfExists('application_process_timestamps');
    }
}
