<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPriorityAddColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('priorities', function (Blueprint $table) {
           $table->string('color')->after('description');
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
        Schema::table('priorities', function(Blueprint $table){
           if(Schema::hasColumn('priorities', 'color')) {
               $table->dropColumn('color');
           }
        });
    }
}
