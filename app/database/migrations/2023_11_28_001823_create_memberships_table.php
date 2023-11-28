<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->integer('inst_id')->unique()->nullable();
            $table->integer('user_id')->unique()->nullable();
            $table->string('category')->nullable();
            $table->string('subCategory')->nullable();
            $table->string('reason')->nullable();
            $table->string('memberId')->nullable();
            $table->string('prodOfInterest')->nullable();
            $table->enum('trdDirection', ['Buy', 'Sell', 'Both'])->nullable();
            $table->integer('avgSizFx')->nullable();
            $table->string('otherProdOfInterest')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('avgValBonds')->nullable();
            $table->integer('avgValTbills')->nullable();
            $table->integer('avgValComPaper')->nullable();
            $table->integer('avgValMmkt')->nullable();
            $table->integer('avgValFx')->nullable();
            $table->integer('avgValDer')->nullable();
            $table->integer('avgSizBonds')->nullable();
            $table->integer('avgSizTbills')->nullable();
            $table->integer('avgSizComPaper')->nullable();
            $table->integer('avgSizMmkt')->nullable();
            $table->integer('avgSizDer')->nullable();
            $table->string('avgValDerCur')->nullable();
            $table->string('avgSizBondsCur')->nullable();
            $table->string('avgSizTbillsCur')->nullable();
            $table->string('avgSizComPaperCur')->nullable();
            $table->string('avgSizMmktCur')->nullable();
            $table->string('avgSizDerCur')->nullable();
            $table->string('avgSizFxCur')->nullable();
            $table->string('avgValBondsCur')->nullable();
            $table->string('avgValTbillsCur')->nullable();
            $table->string('avgValComPaperCur')->nullable();
            $table->string('avgValMmktCur')->nullable();
            $table->string('avgValFxCur')->nullable();
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
        Schema::dropIfExists('memberships');
    }
}
