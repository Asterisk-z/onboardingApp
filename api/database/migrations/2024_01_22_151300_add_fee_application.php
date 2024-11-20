<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeApplication extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('status')->nullable();
            // $table->string('status')->nullable()->change();
            $table->string('concession_file')->after('submitted_by')->nullable();
            $table->tinyInteger('concession_stage')->after('concession_file')->default(0);
            $table->tinyInteger('disclosure_status')->after('concession_stage')->nullable();
            $table->tinyInteger('disclosure_stage')->after('concession_stage')->default(0);
            $table->string('disclosure_signed')->after('concession_stage')->nullable();
            $table->bigInteger('invoice_id')->after('concession_stage')->nullable();
            $table->bigInteger('proof_of_payment')->after('invoice_id')->nullable();
            $table->double('amount_received_by_fsd', 20, 2)->after('proof_of_payment')->nullable();
            $table->tinyInteger('fsd_review_stage')->after('amount_received_by_fsd')->default(0);
            $table->tinyInteger('mbg_review_stage')->after('fsd_review_stage')->default(0);
            $table->tinyInteger('meg_review_stage')->after('mbg_review_stage')->default(0);
            $table->string('application_report')->after('meg_review_stage')->nullable();
            $table->tinyInteger('meg2_review_stage')->after('application_report')->default(0);
            $table->string('office_to_perform_next_action')->after('meg2_review_stage')->nullable();
            $table->string('membership_agreement')->after('office_to_perform_next_action')->nullable();
            $table->string('applicant_executed_membership_agreement')->after('membership_agreement')->nullable();
            $table->boolean('is_applicant_executed_membership_agreement')->after('applicant_executed_membership_agreement')->default(false);
            $table->string('meg_executed_membership_agreement')->after('is_applicant_executed_membership_agreement')->nullable();
            $table->boolean('is_meg_executed_membership_agreement')->after('meg_executed_membership_agreement')->default(false);
            $table->text('e_success_letter')->after('is_meg_executed_membership_agreement')->nullable();
            $table->boolean('e_success_letter_send')->after('e_success_letter')->default(false);
            $table->boolean('member_agreement_send')->after('e_success_letter_send')->default(false);
            $table->boolean('all_ar_uploaded')->after('member_agreement_send')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
}
