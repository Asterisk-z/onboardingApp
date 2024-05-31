<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->boolean('is_event_completed')->default(false);
            $table->boolean('is_sent_for_signing')->default(false);
            $table->string('cert_signature')->nullable();
            $table->string('presentation')->nullable();
            $table->integer('signed_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('is_event_completed');
            $table->dropColumn('is_sent_for_signing');
            $table->dropColumn('cert_signature');
            $table->dropColumn('presentation');
            $table->dropColumn('signed_by');
        });
    }
}
