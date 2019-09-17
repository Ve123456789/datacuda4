<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('name');
            $table->string('stripe_id');
            $table->string('stripe_plan');
            $table->integer('quantity');
            $table->string('object', 22)->default('subscription');
            $table->decimal('application_fee_percent', 6, 2)->nullable()->default(null);
            $table->boolean('cancel_at_period_end')->nullable()->default(false);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('canceled_at')->nullable()->default(null);
            $table->timestamp('current_period_end')->nullable()->default(null);
            $table->timestamp('current_period_start')->nullable()->default(null);
            $table->string('customer', 255);
            $table->string('discount', 255)->nullable()->default(null);
            $table->timestamp('ended_at')->nullable()->default(null);
            $table->boolean('livemode')->nullable()->default(false);
            $table->string('metadata', 255)->nullable()->default(null);
            $table->timestamp('start')->nullable()->default(null);
            $table->string('status', 255);
            $table->decimal('tax_percent', 6, 2)->nullable()->default(null);
            $table->timestamp('trial_end_at')->nullable()->default(null);
            $table->timestamp('trial_start_at')->nullable()->default(null);
	        $table->timestamp('ends_at')->nullable()->default(null);
            $table->integer('created_by')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);

            /**
             * Add Foreign/Unique/Index
             */
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
