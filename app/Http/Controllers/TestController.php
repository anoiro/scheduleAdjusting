<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//データベースアクセスするためにモデルを引っ張る必要がある
use App\Models\Test;

class TestController extends Controller
{
    //web.phpでtests\testにアクセスして飛ばされた先がここ
    public function index(){
        $values=Test::all();
        //dd($values); //変数の中身を表示してくれる。デバックに使えそう
        return view('tests.test', compact('values'));
        //resouceフォルダの中でpublicに宣言されているview関数を呼び出す。
    }

}
