<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MediaUserProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_user_projects', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('media_id')->unsigned()->index();
            $table->integer('user_projects_id')->unsigned()->index();
            $table->integer('amount')->unsigned()->index();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_user_projects');
    }
}
