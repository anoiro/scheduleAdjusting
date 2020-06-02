<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfolio1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolio1s', function (Blueprint $table) {
            $table->bigIncrements('id'); #実験ID
            $table->bigInteger('labID'); #研究室ID
            $table->string('name',255); #実験名
            $table->bigInteger('imgID')->nullable(); #実験風景画像ID
            $table->date('start'); #開始日
            $table->date('end'); #終了予定日
            $table->bigInteger('recruit'); #募集人数
            $table->bigInteger('thanks'); #礼金
            $table->string('room',100); #会場
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
        Schema::dropIfExists('portfolio1s');
    }
}
