<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailtoMembershipCategoryPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('membership_category_postitions', function (Blueprint $table) {
            $table->foreignId('group_mail_id')->nullable();
            $table->enum('is_compulsory', ['1', '0'])->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('membership_category_postitions', function (Blueprint $table) {
            $table->dropColumn('group_mail_id');
            $table->dropColumn('is_compulsory');
        });

    }
}
