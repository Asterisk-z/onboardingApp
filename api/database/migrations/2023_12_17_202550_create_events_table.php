<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->boolean('is_annual');
            $table->decimal('fee', 10, 2); // 0 means free
            $table->string('image')->nullable();

            // can set dates or set frequency and start date but not both
            $table->date('registered_remainder_start_date')->nullable();
            $table->enum('registered_remainder_frequency', ['Daily', 'Weekly', 'Monthly'])->nullable();

            $table->date('unregistered_remainder_start_date')->nullable();
            $table->enum('unregistered_remainder_frequency', ['Daily', 'Weekly', 'Monthly'])->nullable();


            // for system use
            $table->date('last_reminder_date')->nullable();
            //$table->date('next_reminder_date')->nullable();

            // for system use
            $table->date('last_reminder_date_non_registered')->nullable();
            //$table->date('next_reminder_date_non_registered')->nullable();

            $table->bigInteger('user_id');


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
        Schema::dropIfExists('events');
    }
}
