<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolio1AdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio1_admins', function (Blueprint $table) {
            $table->bigIncrements('id'); #実験者ID
            $table->bigInteger('labID'); #研究室ID
            $table->char('your_name',100); #氏名
            $table->string('password'); #パスワード
            $table->string('email',255)->unique(); #メールアドレス
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('portfolio1_admins');
    }
}
