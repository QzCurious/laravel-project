<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 14)->nullable();
            $table->date('birthday')->nullable();
            $table->unsignedTinyInteger('gender')->nullable()->comment('1:Male, 2:Female');
            $table->string('address', 40)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('birthday');
            $table->dropColumn('gender');
            $table->dropColumn('address');
        });
    }
}
