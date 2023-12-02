<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfHighlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('pdf_highlights'))
            return;
        Schema::create('pdf_highlights', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('mem_id')->nullable();
            $table->integer('inst_id')->nullable();
            $table->integer('annotation_id')->nullable();
            $table->text('annotation')->nullable();
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
        Schema::dropIfExists('pdf_highlights');
    }
}
