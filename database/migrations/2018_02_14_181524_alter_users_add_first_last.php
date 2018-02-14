<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddFirstLast extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function(Blueprint $table) {
            $table->string('last_name')->after('name');
            $table->renameColumn('name','first_name');

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
        Schema::table('users', function(Blueprint $table){
            if(Schema::hasColumn('users','first_name')) {
                $table->renameColumn('first_name', 'name');
            }
            if (Schema::hasColumn('users', 'last_name')) {
                $table->dropColumn('last_name');
            }

        });
    }
}
