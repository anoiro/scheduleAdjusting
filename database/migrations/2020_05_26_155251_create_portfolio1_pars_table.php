<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolio1ParsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio1_pars', function (Blueprint $table) {
            $table->bigIncrements('id'); #参加者ID
            $table->char('number',8); #学籍番号
            $table->char('your_name',100); #氏名
            $table->boolean('gender')->unsigned(); #性別
            $table->tinyInteger('age'); #年齢
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
        Schema::dropIfExists('portfolio1_pars');
    }
}
