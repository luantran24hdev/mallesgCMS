<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLaraPasswordToUserMaster extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_master', function (Blueprint $table) {
            $table->string('remember_token')->nullable()->after('password');            
            $table->string('lara_password')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_master', function (Blueprint $table) {
            $table->dropColumn('remember_token');
            $table->dropColumn('lara_password');
        });
    }
}
