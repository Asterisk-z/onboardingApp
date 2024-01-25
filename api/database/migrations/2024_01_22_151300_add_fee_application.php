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
            // $table->double('applied_quarter_discount', 8, 2)->after('status')->default(0);
            // $table->string('concession_file')->after('concession_value')->nullable();

            // $table->tinyInteger('concession_stage')->after('concession_file')->default(0);

            // $table->bigInteger('invoice_id')->after('concession_stage')->nullable();
            // $table->string('proof_of_payment')->after('invoice_id')->nullable();

            // $table->string('fsd_payment_status')->after('proof_of_payment')->nullable();
            // $table->string('fsd_payment_comment')->after('fsd_payment_status')->nullable();

            // $table->string('mbg_payment_status')->after('fsd_payment_comment')->nullable();
            // $table->string('mbg_payment_comment')->after('mbg_payment_status')->nullable();

            // $table->string('meg_status')->after('mbg_payment_comment')->nullable();
            // $table->string('meg_comment')->after('meg_status')->nullable();
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
