<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('media_type', 50);
            $table->tinyInteger('access')->default('0');
            $table->string('title', 255)->nullable()->default(null);
            $table->string('filename', 255);
            $table->string('ext', 10);
            $table->float('amount')->nullable()->default(0);
            $table->tinyInteger('status')->default('1');
            $table->integer('created_by')->nullable()->default(null);
            $table->integer('updated_by')->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
            $table->integer('deleted_by')->nullable()->default(null);
            $table->integer('size')->nullable()->default(0);
            $table->integer('is_cover')->default(0);
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
        Schema::dropIfExists('medias');
    }
}
