<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFeeCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('membership_categories', function (Blueprint $table) {
            $table->double('application_fee', 20, 2)->after('name')->default(0);
            $table->double('membership_dues', 20, 2)->after('application_fee')->default(0);
            $table->integer('max_ar')->after('application_fee')->default(0);
            $table->string('singular_name')->after('name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('membership_categories', function (Blueprint $table) {
            //
        });
    }
}
