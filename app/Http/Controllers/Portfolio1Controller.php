<?php

namespace App\Http\Controllers;

use App\Models\candidate;
use Illuminate\Http\Request;

use App\Models\Portfolio1;
use App\Models\Image;
use App\Models\Confirm;
use App\Models\Experimenter;
use App\Models\Lab;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Portfolio1Controller extends Controller
{
    public function index()
    {
        $exps = DB::table('portfolio1s')
            ->join('labs', 'portfolio1s.labID', '=', 'labs.id')
            ->select('portfolio1s.*', 'labs.prof',)
            ->get();
        $experimenter = Experimenter::find(Auth::id());

        return view('portfolio1.index', compact('exps', 'experimenter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $labImgs = DB::table('images') #自分の研究室の他の画像
            ->select('id', 'labID', 'expID', 'img')
            ->where('images.labID', $experimenter->labID)
            ->get();

        return view('portfolio1.create', compact('experimenter', 'lab', 'labImgs'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //実験内容(画像以外)
        $portfolio1 = new Portfolio1;
        $portfolio1->labID = $request->input('labID');
        $portfolio1->expName = $request->input('expName');
        $portfolio1->start = $request->input('start');
        $portfolio1->end = $request->input('end');
        $portfolio1->recruit = $request->input('recruit');
        $portfolio1->thanks = $request->input('thanks');
        $portfolio1->room = $request->input('room');
        $portfolio1->weekend = $request->input('weekend');
        $portfolio1->save();

        //画像
        if ($_FILES['img']['tmp_name'] != null) {
            $image = new Image;
            $image->labID = $portfolio1->labID;
            $image->expID = $portfolio1->id;
            $image->img = file_get_contents($_FILES['img']['tmp_name']);
            $image->save();

            //実験テーブルの画像IDを登録
            $portfolio1->imageID = $image->id;
            $portfolio1->save();
        }

        return redirect('exper/index');
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
        $experimenter = Experimenter::find(Auth::id());
        $candidateCount = DB::table('candidates')
            ->where('expID', $exp->id)
            ->count();

        return view('portfolio1.show', compact('exp', 'img', 'labs', 'experimenter', 'candidateCount'));
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
        return redirect('exper/index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $portfolio1 = Portfolio1::find($id);
        $portfolio1->delete();

        return redirect('exper/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeImg(Request $request)
    {
        $image = new Image;
        $image->labID = $request->input('labID');
        $image->expID = $request->input('expID');
        $image->img = file_get_contents($_FILES['img']['tmp_name']);
        $image->save();

        $exp = Portfolio1::find($request->input('expID'));
        $exp->imageID = $image->id;
        $exp->save();

        return redirect('exper/index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDate($expID)
    {
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $exp = Portfolio1::find($expID);
        $start = new Carbon($exp->start);
        $end = new Carbon($exp->end);

        $img = Image::find($exp->imageID);
        $candidates = DB::table('candidates')
            ->where('expID', $exp->id)
            ->get();
        foreach ($candidates as $candidate) {
            $candidatesArray[] = $candidate;
            //$nonUniParticipants[] = User::find($candidate->participantID);
            $participants[$candidate->participantID] = User::find($candidate->participantID);
        }
        //$participants = array_unique($nonUniParticipants);
        $dates = array_column($candidatesArray, 'datetime');

        $participantIDs = array_unique(array_column($candidatesArray, 'participantID'));

        if ($start->year == $end->year) {
            $betweenMonths = $end->month - $start->month + 1;
        } else {
            $betweenMonths = (12 - $start->month + 1) +
                12 * ($end->year - ($start->year + 1)) +
                $end->month;
        }
        $j = 0;
        while ($j < $betweenMonths) {
            $calendars[] = calendar(new Carbon($start->format('Y-m-d')));
            $start->modify('+1 month');
            $j = $j + 1;
        }
        $start1 = new Carbon($exp->start);

        return view('portfolio1.createDate', compact('experimenter', 'lab', 'exp', 'start', 'img', 'candidates', 'dates', 'participants', 'calendars', 'start1'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeDate(Request $request)
    {
        foreach (array_keys($request->input('confirms')) as $participantID) {
            $confirm = new Confirm;
            $confirm->expID = $request->input('expID');
            $confirm->participantID = $participantID;
            $confirm->datetime = Candidate::find($request->input('confirms')[$participantID][0])->datetime;
            $confirm->save();
        }
        return redirect('exper/index');
    }
}
