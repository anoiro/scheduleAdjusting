<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio1;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\User;
//use App\Models\Participant;
use Auth;

class Portfolio1ParController extends Controller
{
    //
    public function index()
    {
        $exps = DB::table('portfolio1s')
            ->join('labs', 'portfolio1s.labID', '=', 'labs.id')
            ->select('portfolio1s.*', 'labs.prof',)
            ->get();

        return view('portfolio1par.index', compact('exps'));
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

        return view('portfolio1par.show', compact('exp', 'img', 'labs'));
    }

    public function create($id)
    {
        $participant = Auth::user();
        $exp = Portfolio1::find($id);

        return view('portfolio1par.create', compact('participant', 'exp'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
}
