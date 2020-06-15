<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Portfolio1;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\User;
//use App\Models\Participant;
use Auth;
use Carbon\Carbon;

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

    public function create(Request $request, $id)
    {
        $participant = Auth::user();
        $exp = Portfolio1::find($id);
        $date = new Carbon($exp->start);
        //$calendar = calendar($date->firstOfMonth());
        $calendar = calendar($date);

        return view('portfolio1par.create', compact('participant', 'exp', 'calendar', 'date'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        print(88);
    }
}
