<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_agreements', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id')->unique();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('rc_number')->nullable();
            $table->string('authorised_signatory_name_one')->nullable();
            $table->string('authorised_signatory_designation_one')->nullable();
            $table->string('authorised_signatory_signature_one')->nullable();
            $table->string('authorised_signatory_name_two')->nullable();
            $table->string('authorised_signatory_designation_two')->nullable();
            $table->string('authorised_signatory_signature_two')->nullable();
            $table->timestamp('date');
            $table->text('data')->nullable();
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
        Schema::dropIfExists('member_agreements');
    }
}
