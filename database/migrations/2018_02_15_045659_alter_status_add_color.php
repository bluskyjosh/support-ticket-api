<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterStatusAddColor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('statuses', function (Blueprint $table) {
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
        Schema::table('statuses', function(Blueprint $table){
            if(Schema::hasColumn('statuses', 'color')) {
                $table->dropColumn('color');
            }
        });
    }
}
