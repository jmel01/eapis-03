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
            $table->string('grant_id');
            $table->string('user_id')->nullable();
            $table->date('dateRcvd');
            $table->string('payee');
            $table->string('particulars')->nullable();
            $table->float('amount', 10, 2);
            $table->string('checkNo')->nullable();
            $table->string('province')->nullable();
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
