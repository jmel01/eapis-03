<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('lastName');
            $table->string('firstName');
            $table->string('middleName');
            $table->date('birthdate');
            $table->string('placeOfBirth');
            $table->string('gender');
            $table->string('civilStatus');
            $table->string('ethnoGroup');
            $table->string('contactNumber')->nullable();
            $table->string('email');
            $table->string('address');
            $table->string('psgCode');
            $table->string('fatherLiving');
            $table->string('fatherName');
            $table->string('fatherAddress');
            $table->string('fatherOccupation')->nullable();
            $table->string('fatherOffice')->nullable();
            $table->string('fatherEducation')->nullable();
            $table->string('fatherEthnoGroup')->nullable();
            $table->string('fatherIncome')->nullable();
            $table->string('motherLiving');
            $table->string('motherName');
            $table->string('motherAddress');
            $table->string('motherOccupation')->nullable();
            $table->string('motherOffice')->nullable();
            $table->string('motherEducation')->nullable();
            $table->string('motherEthnoGroup')->nullable();
            $table->string('motherIncome')->nullable();

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
        Schema::dropIfExists('profiles');
    }
}
