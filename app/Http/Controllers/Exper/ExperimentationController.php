<?php

namespace App\Http\Controllers\Exper;

use App\Models\Candidate;
use Illuminate\Http\Request;

use App\Models\Experimentation;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Confirm;
use App\Models\Experimenter;
use App\Models\Lab;
use Auth;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExperimentationController extends Controller
{
    public function index()
    {
        $exps = DB::table('experimentations')
            ->join('labs', 'experimentations.labID', '=', 'labs.id')
            ->select('experimentations.*', 'labs.prof',)
            ->get();
        $experimenter = Experimenter::find(Auth::id());

        // return view('portfolio1.index', compact('exps', 'experimenter'));
        return view('exper.index', compact('exps', 'experimenter'));
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

        // return view('portfolio1.create', compact('experimenter', 'lab', 'labImgs'));
        return view('exper.create', compact('experimenter', 'lab', 'labImgs'));
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
        $experimentation = new Experimentation;
        $experimentation = $request->validated();
        $experimentation->labID = $request->input('labID');
        $experimentation->expName = $request->input('expName');
        $experimentation->start = $request->input('start');
        $experimentation->end = $request->input('end');
        $experimentation->recruit = $request->input('recruit');
        $experimentation->thanks = $request->input('thanks');
        $experimentation->room = $request->input('room');
        $experimentation->weekend = $request->input('weekend');
        $experimentation->save();

        //画像
        if ($_FILES['img']['tmp_name'] != null) {
            $image = new Image;
            $image->labID = $experimentation->labID;
            $image->expID = $experimentation->id;
            $image->img = base64_encode(file_get_contents($request->img->getRealPath()));
            $image->save();

            //実験テーブルの画像IDを登録
            $experimentation->imageID = $image->id;
            $experimentation->save();
        }

        return redirect('exper/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show(Experimentation $exp)
    public function show($expID)
    {
        $exp = Experimentation::find($expID);
        $img = Image::find($exp->imageID);
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $candidateCount = DB::table('candidates')
            ->where('expID', $exp->id)
            ->count();

        // return view('portfolio1.show', compact('exp', 'img', 'lab', 'experimenter', 'candidateCount'));
        return view('exper.show', compact('exp', 'img', 'lab', 'experimenter', 'candidateCount'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Experimentation $exp)
    {
        // $exp = Experimentation::find($id);
        $img = Image::find($exp->imageID);
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $labImgs = DB::table('images') #自分の研究室の他の画像
            ->select('id', 'labID', 'expID', 'img')
            ->where('images.labID', $exp->labID)
            ->get();
        $labIDs = DB::table('labs') #他の研究室も含めたIDたち
            ->select('id', 'prof')
            ->get();

        // return view('portfolio1.edit', compact('exp', 'img', 'lab', 'labImgs', 'labIDs'));
        return view('exper.edit', compact('exp', 'img', 'lab', 'labImgs', 'labIDs'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Experimentation $exp)
    {
        // $experimentation = Experimentation::find($id);

        $exp->labID = $request->input('labID');
        $exp->expName = $request->input('expName');
        //ゆくゆくは画像の更新もできるようにしたい
        //$exp->imageID = $request->input('imageID');
        $exp->start = $request->input('start');
        $exp->end = $request->input('end');
        $exp->recruit = $request->input('recruit');
        $exp->thanks = $request->input('thanks');
        $exp->room = $request->input('room');

        //上で代入した値たちを保存する
        $exp->save();
        //indexページに飛ばすheaderみたいな感じかな
        return redirect('exper/index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experimentation $exp)
    {
        // $experimentation = Experimentation::find($id);
        // $experimentation->delete();
        $exp->delete();

        return redirect('exper/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createImg()
    {
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $exps = DB::table('experimentations')
            ->where('labID', $lab->id)
            ->get();

        // return view('portfolio1.createImg', compact('experimenter', 'lab', 'exps'));
        return view('exper.createImg', compact('experimenter', 'lab', 'exps'));
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
        $image = $request->validated();
        $image->labID = $request->input('labID');
        $image->expID = $request->input('expID');
        $image->img = base64_encode(file_get_contents($request->img->getRealPath()));
        $image->save();

        $exp = Experimentation::find($request->input('expID'));
        $exp->imageID = $image->id;
        $exp->save();

        return redirect('exper/index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDate(Experimentation $exp)
    {
        $experimenter = Experimenter::find(Auth::id());
        $lab = Lab::find($experimenter->labID);
        $start = new Carbon($exp->start);
        $end = new Carbon($exp->end);

        $img = Image::find($exp->imageID);

        $candidates = DB::table('candidates')
            ->where('expID', $exp->id)
            ->get();

        foreach ($candidates as $candidate) {
            $candidatesArray[] = $candidate;
            // $participants[$candidate->participantID] = User::find($candidate->participantID);
            $participants[$candidate->participantID] = $candidates->users()->$candidate->participantID;
        }
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
        $start = new Carbon($exp->start);

        // return view('portfolio1.createDate', compact('experimenter', 'lab', 'exp', 'start', 'img', 'candidates', 'dates', 'participants', 'calendars'));
        return view('exper.createDate', compact('experimenter', 'lab', 'exp', 'start', 'img', 'candidates', 'dates', 'participants', 'calendars'));
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
            $confirm = $request->validated();
            $confirm->expID = $request->input('expID');
            $confirm->participantID = $participantID;
            $confirm->datetime = Candidate::find($request->input('confirms')[$participantID][0])->datetime;
            $confirm->save();
        }
        return redirect('exper/index');
    }
}