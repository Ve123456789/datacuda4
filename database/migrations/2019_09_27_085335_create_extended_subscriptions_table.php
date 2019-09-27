<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtendedSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extended_subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger ('user_subscription_id')->comment ('refrence: user_subscription');
            $table->unsignedInteger ('plan_id')->comment('refrence: plans');
            $table->string ('storage_quantity') ->nullable ();
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
        Schema::dropIfExists('extended_subscriptions');
    }
}
