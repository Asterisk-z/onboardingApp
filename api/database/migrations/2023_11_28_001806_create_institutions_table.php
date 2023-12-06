<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('institutions'))
            return;
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('institutionName')->nullable();
            $table->string('user_id')->nullable();

            $table->string('address')->nullable();

            $table->string('incorporationDate')->nullable();

            $table->string('incorporationPlace')->nullable();

            $table->string('license')->nullable();

            $table->string('tel')->nullable();
            $table->string('tel2')->nullable();

            $table->string('email')->nullable();

            $table->string('email2')->nullable();

            $table->string('website')->nullable();

            $table->string('businessNature')->nullable();

            $table->string('authrizedCapital')->nullable();

            $table->string('paidUpCapital')->nullable();

            $table->string('authrizedCapitalCur')->nullable();
            $table->string('paidUpCapitalCur')->nullable();

            $table->string('rcNo')->nullable();
            $table->string('bank1Name')->nullable();

            $table->string('bank1Address')->nullable();

            $table->string('bank1Tel')->nullable();
            $table->string('bank1MgrEmail')->nullable();

            $table->string('bank1MgrMobile')->nullable();

            $table->string('bank1ActType')->nullable();

            $table->string('bank2Name')->nullable();
            $table->string('bank2Address')->nullable();

            $table->string('bank2Tel')->nullable();

            $table->string('bank2MgrEmail')->nullable();

            $table->string('bank2MgrMobile')->nullable();

            $table->string('bank2ActType')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institutions');
    }
}
