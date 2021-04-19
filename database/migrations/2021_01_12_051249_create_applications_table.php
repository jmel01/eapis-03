<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('grant_id');
            $table->string('user_id');
            $table->string('type');
            $table->string('level');
            $table->string('school');
            $table->string('course');
            $table->text('contribution');
            $table->text('plans');
            $table->string('status')->default('On Process');
            $table->string('remarks')->nullable();
            $table->timestamp('date_process')->nullable();
            $table->timestamp('date_approved')->nullable();
            $table->timestamp('date_graduated')->nullable();
            $table->timestamp('date_terminated')->nullable();
            $table->timestamp('date_denied')->nullable();
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
        Schema::dropIfExists('applications');
    }
}
