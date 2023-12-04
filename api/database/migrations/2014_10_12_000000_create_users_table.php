<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('users'))
            return;

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('nationality');
            $table->integer('institution_id')->nullable();
            $table->integer('position_id')->nullable();
            $table->integer('role_id');
            $table->string('reg_id')->nullable();
            $table->string('img')->nullable();
            $table->string('created_by')->default('self')->comment('Self: This is for applicants, Other users would have the id of the creator');
            $table->string('approval_status')->default('pending')->comment('pending, approved, declined');
            $table->string('approval_status_by')->default('self')->comment('Self: This is for applicants, Other users would have the id of the creator');
            $table->tinyInteger('is_del')->default(0);
            $table->json('update_payload')->nullable();
            $table->timestamp('verified_at')->nullable();            
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
        Schema::dropIfExists('users');
    }
}
