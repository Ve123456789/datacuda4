<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscription', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger ('user_id')->comment ('refrence: users');
            $table->unsignedInteger ('plan_id')->comment ('refrence: plans');
            $table->unsignedBigInteger ('storage_quantity')->nullable()->comment ('Store the quantity provided to user in bytes');
            $table->float ('amount', 8,2)->nullable()->comment ('amount paid by user to purchase this subscription');
            $table->date ('expire_at')->nullable ()->comment ('date of expiry of the subscription plan');
            $table->boolean ('status')->comment ('check if user request for it\'s cancellation');
            $table->timestamps();
            $table->dropSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}
