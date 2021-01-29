<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_costs', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->nullable();
            $table->string('grant_id');
            $table->string('user_id')->nullable();
            $table->date('dateRcvd');
            $table->string('payee');
            $table->string('particulars')->nullable();
            $table->string('amount');
            $table->string('checkNo')->nullable();
            $table->string('province');
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
        Schema::dropIfExists('admin_costs');
    }
}
