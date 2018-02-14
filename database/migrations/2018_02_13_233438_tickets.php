<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tickets', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->integer('priority_id')->unsigned();
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->string('ticket_id')->unique();
            $table->string('title');
            $table->text('description');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->integer('created_by_id')->unsigned();
            $table->foreign('created_by_id')->references('id')->on('users');
            $table->integer('updated_by_id')->unsigned()->nullable();
            $table->foreign('updated_by_id')->references('id')->on('users');
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
        //
    }
}
