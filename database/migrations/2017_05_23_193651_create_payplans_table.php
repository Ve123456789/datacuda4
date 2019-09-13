<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payplans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('object', 10)->default('plan');
            $table->string('name', 255);
            $table->string('currency', 10);
            $table->integer('amount')->nullable()->default(null)->unsigned();
            $table->integer('amount_ordinary')->nullable()->default(null);
            $table->string('interval', 255);
            $table->integer('interval_count')->default(1)->unsigned();
            $table->integer('trial_perioddays')->nullable();
            $table->string('statement_descriptor', 22);
            $table->integer('status');
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
        Schema::dropIfExists('payplans');
    }
}
