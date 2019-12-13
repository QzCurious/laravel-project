<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOauthAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oauth_accounts', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->string('provider', 30)->comment('Name of OAuth provider, defined by Socialite');
            // OpenID specification state the sub should not exceed 255 ASCII characters in length.
            // https://openid.net/specs/openid-connect-core-1_0.html#IDToken
            $table->string('sub')->comment('Unique identifier for an user to an OAuth provider server');
            $table->timestamps();
        });

        Schema::table('oauth_accounts', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oauth_accounts');
    }
}
