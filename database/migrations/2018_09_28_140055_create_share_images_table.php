<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShareImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('project_id')->nullable();
            $table->integer('image_id')->nullable();
            $table->longText('recipient_id');
            $table->string('fist_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email');
            $table->longText('address')->nullable();
            $table->string('city',100)->nullable();
            $table->string('state',100)->nullable();
            $table->string('zip',50)->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('invoice_date')->nullable();
            $table->longText('description')->nullable();
            $table->longText('amount')->nullable();
            $table->longText('amount_type')->nullable();
            $table->longText('massage')->nullable();
            $table->integer('buy_status')->length(1)->default(0);
            $table->string('delete_after')->nullable();
            $table->longText('project_password');
            $table->string('include_condition')->nullable();
            $table->string('send_as')->nullable();
            $table->string('buy_amount');
            $table->integer('status')->length(1)->default(0);
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
        Schema::dropIfExists('share_images');
    }
}
