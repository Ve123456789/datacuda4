<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username')->nullable()->default(null);
            $table->string('name')->nullable();
            $table->string('lastname')->nullable();
            $table->string('picture')->nullable()->default(null);
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('chosen_payment_id')->nullable();
            $table->string('last_payment', 10)->nullable();
            $table->string('next_payment_before', 10)->nullable();
            $table->string('stripe_id')->nullable();
            $table->string('card_brand')->nullable();
            $table->string('card_last_four')->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->boolean('active')->default(1);
            $table->integer('status')->nullable();
            $table->rememberToken()->nullable();
            $table->timestamp('created_at')->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
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
