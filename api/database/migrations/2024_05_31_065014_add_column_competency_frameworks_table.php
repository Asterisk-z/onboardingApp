<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnCompetencyFrameworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('competency_frameworks', function (Blueprint $table) {
            $table->enum('expected_proficiency', ["Compulsory", "Basic", "Intermediate", "Advanced", "Expert", "Not Applicable"])->default('Not Applicable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('competency_frameworks', function (Blueprint $table) {
            $table->dropColumn('expected_proficiency');
        });
    }
}
