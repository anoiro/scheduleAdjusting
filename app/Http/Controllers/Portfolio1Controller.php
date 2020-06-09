<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio1;
use App\Models\Image;
use Illuminate\Support\Facades\DB;

class Portfolio1Controller extends Controller
{
    public function index()
    {
        //クエリビルダ
        $exps = DB::table('portfolio1s')
            ->join('labs', 'portfolio1s.labID', '=', 'labs.id')
            ->select('portfolio1s.*', 'labs.prof',)
            ->get();

        return view('portfolio1.index', compact('exps'));
    }

    public function create()
    {
        $experimenter = DB::table('experimenters')
        ->select() //experimenterが認証されたときのLabIDを取ってくる処理を追加したい
        ->get();
        $labs = DB::table('labs')
        ->select('id', 'prof')
        ->get();
        $labImgs = DB::table('images') #自分の研究室の他の画像
        ->select('id', 'labID', 'expID', 'img')
        //->where('images.labID', $experimenter->labID)
        ->get();

        return view('portfolio1.create', compact('labs', 'labImgs'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //前までは$_POST['name']みたいに書いて変数を持ってきていたけどLaravelの場合は
        //Request型の変数として扱うことができる
        //ちなみにRequestクラスはDI(依存性の注入)によるインスタンス化されたクラス

        //ContactFormクラスをインスタンス化
        $portfolio1 = new Portfolio1;
        $portfolio1->labID = $request->input('labID');
        $portfolio1->expName = $request->input('expName');
        //$portfolio1->imageID = $request->input('imageID');
        $portfolio1->start = $request->input('start');
        $portfolio1->end = $request->input('end');
        $portfolio1->recruit = $request->input('recruit');
        $portfolio1->thanks = $request->input('thanks');
        $portfolio1->room = $request->input('room');

        //上で代入した値たちを保存する
        $portfolio1->save();
        //indexページに飛ばすheaderみたいな感じかな
        return redirect('portfolio1/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $exp = Portfolio1::find($id);
        $img = Image::find($exp->imageID);
        $labs = DB::table('labs')
            ->select('id', 'prof')
            ->where('labs.id', $exp->labID)
            ->get();

        //ファットコントローラーにならないようにする
        // $gender = CheckFormData::checkGender($exp);
        // $age = CheckFormData::checkAge($exp);
        //dd($exp);

        return view('portfolio1.show', compact('exp', 'img', 'labs'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $exp = Portfolio1::find($id);
        $img = Image::find($exp->imageID);
        $labs = DB::table('labs') #自分の研究室の指導教員
            ->select('id', 'prof',)
            ->where('labs.id', $exp->labID)
            ->get();
        $labImgs = DB::table('images') #自分の研究室の他の画像
            ->select('id', 'labID', 'expID', 'img')
            ->where('images.labID', $exp->labID)
            ->get();
        $labIDs = DB::table('labs') #他の研究室も含めたIDたち
            ->select('id', 'prof')
            ->get();

        return view('portfolio1.edit', compact('exp', 'img', 'labs', 'labImgs', 'labIDs'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $portfolio1 = Portfolio1::find($id);

        $portfolio1->labID = $request->input('labID');
        $portfolio1->expName = $request->input('expName');
        //ゆくゆくは画像の更新もできるようにしたい
        //$portfolio1->imageID = $request->input('imageID');
        $portfolio1->start = $request->input('start');
        $portfolio1->end = $request->input('end');
        $portfolio1->recruit = $request->input('recruit');
        $portfolio1->thanks = $request->input('thanks');
        $portfolio1->room = $request->input('room');

        //上で代入した値たちを保存する
        $portfolio1->save();
        //indexページに飛ばすheaderみたいな感じかな
        return redirect('portfolio1/index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $portfolio1 = Portfolio1::find($id);
        $portfolio1->delete();

        return redirect('portfolio1/index');
    }

    public function createImg()
    {
        $experimenter = DB::table('experimenters')
            ->select() //experimenterが認証されたときのLabIDを取ってくる処理を追加したい
            ->get();
        $labs = DB::table('labs')
            ->select('id', 'prof')
            ->get();
        //createImg()の引数に実験者のlabIDを
        //取るようにしたい
        //今は他の研究室がやっている実験の風景としても
        //登録できる状態
        $exps = DB::table('portfolio1s')
            ->select('id', 'labID', 'expName')
            // ->where('labID',$labID)
            ->get();

        return view('portfolio1.createImg', compact('labs', 'exps'));
    }

    public function storeImg(Request $request)
    {
        $image = new Image;
        $image->labID = $request->input('labID');
        $image->expID = $request->input('expID');
        $image->img = file_get_contents($_FILES['img']['tmp_name']);

        $image->save();
        return redirect('portfolio1/index');
    }
}