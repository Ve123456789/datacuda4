<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->increments('id');
            $table->string ('name')->nullable()->comment ('name of the subscription plan');
            $table->smallInteger ('storage_quantity')->nullable()->comment ('Quantity of storage');
            $table->string('storage_unit', 2)->nullable()->comment('Unit of storage like mb, gb, tb, etc');
            $table->smallInteger ('vailidity_quantity')->nullable()->comment('Validity number of plan');
            $table->string ('validity_unit', 6)->nullable ()->comment ('Unit of validity like: days, months, years');
            $table->float ('commission', 8,2)->nullable ()->comment ('commission offered by plan');
            $table->json ('benifits')->nullable ()-> comment ('All benifits offered by plan');
            $table->boolean ('active')->comment ('Check if plan is active or not');
            $table->float ('amount', 8,2)->nullable () -> comment ('Amount charged by plan');
            $table->boolean ('additional')->comment ('Check if plan is aditional to current plan');
            $table->smallInteger ('additional_plan_id')->comment ('Check if plan is addition for which plan?');
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
        Schema::dropIfExists('plans');
    }
}
