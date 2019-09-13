<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_profile', function (Blueprint $table) {
            $table->increments('id');
			$table->integer('user_id');
            $table->string('company_name')->unique();
            $table->string('company_address')->nullable();
            $table->string('company_city')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_zip')->nullable();
            $table->string('company_country')->nullable();
            $table->string('payment_type')->nullable();
			$table->string('company_phone_buss')->nullable();
            $table->string('company_phone_fax')->nullable();
            $table->string('company_business_email')->nullable();
            $table->string('company_website')->nullable();
            $table->string('company_currency')->nullable();
			$table->string('company_logo')->nullable();
			$table->string('other_image')->nullable();
			$table->dateTime('company_join_date')->nullable();
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
        Schema::dropIfExists('company_profile');
    }
}