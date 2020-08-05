<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Models\Experimentation;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Candidate;
use App\Models\Lab;
use Auth;
use Carbon\Carbon;
use Illuminate\Validation\Rules\Exists;

class ExperimentationController extends Controller
{
    public function index()
    {
        $exps = DB::table('experimentations')
            ->join('labs', 'experimentations.labID', '=', 'labs.id')
            ->select('experimentations.*', 'labs.prof',)
            ->get();
        $participant = Auth::user();
        $expIDs = DB::table('candidates')
            ->select('expID')
            ->where('participantID', $participant->id)
            ->get();
        if ($expIDs->isEmpty()) {
            $expIDsArray = [];
        } else {
            //DBからとってきたObject型のexpIDsから
            //要素を一つずつ取り出して配列に格納
            foreach ($expIDs as $expID) {
                $expIDsArrays[] = $expID;
            }
            //格納した配列は行ごとにフィールドをキーにした
            //連想配列になっているからただのインデックスに
            //変える
            $expIDsArray = array_column($expIDsArrays, 'expID');
        }

        //confirm用
        $confirmedExpIDs = DB::table('confirms')
            ->select('expID')
            ->where('participantID', $participant->id)
            ->get();
        if ($confirmedExpIDs->isEmpty()) {
            $confirmedExpIDsArray = [];
        } else {
            //DBからとってきたObject型のexpIDsから
            //要素を一つずつ取り出して配列に格納
            foreach ($confirmedExpIDs as $confirmedExpID) {
                $confirmedExpIDsArrays[] = $confirmedExpID;
            }
            //格納した配列は行ごとにフィールドをキーにした
            //連想配列になっているからただのインデックスに
            //変える
            $confirmedExpIDsArray = array_column($confirmedExpIDsArrays, 'expID');
        }

        // return view('portfolio1par.index', compact('exps', 'participant', 'expIDsArray', 'confirmedExpIDsArray'));
        return view('user.index', compact('exps', 'participant', 'expIDsArray', 'confirmedExpIDsArray'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    public function show(experimentation $exp)
    {
        // $exp = experimentation::find($id);
        $img = Image::find($exp->imageID);
        $lab = Lab::find($exp->labID);

        // return view('portfolio1par.show', compact('exp', 'img', 'lab'));
        return view('user.show', compact('exp', 'img', 'lab'));
    }

    public function create(Request $request, experimentation $exp)
    {
        $participant = Auth::user();
        // $exp = experimentation::find($id);
        $start = new Carbon($exp->start);
        $end = new Carbon($exp->end);
        
        //カレンダーの日程を生成している。これが暫定ベスト
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
        
        //開始日より前、終了日より後の日程を選択できない
        //ように制限をかけるためのCarbon
        $startRes = new Carbon($exp->start);
        $endRes = new Carbon($exp->end);

        // return view('portfolio1par.create', compact('participant', 'exp', 'start', 'end', 'calendars', 'startRes', 'endRes'));
        return view('user.create', compact('participant', 'exp', 'start', 'end', 'calendars', 'startRes', 'endRes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $participantID)
    {
        foreach ($request->input('candidate') as $datetime) {
            $candiDate = new Candidate;
            $candiDate->expID = $request->input('expID');
            $candiDate->participantID = $participantID;
            $candiDate->datetime = $datetime;
            $candiDate->save();
        }

        return redirect('user/index');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(experimentation $exp)
    {
        $participant = Auth::user();
        // $exp = experimentation::find($expID);
        $date = new Carbon($exp->start);

        $calendar = calendar($date);

        $expIDs = DB::table('candidates')
            ->select('expID', 'participantID', 'datetime')
            ->where('expID', $exp->id)
            ->get();
        foreach ($expIDs as $value) {
            $exps[] = $value;
        }
        $datetimes = array_column($exps, 'datetime');
        
        $startRes = new Carbon($exp->start);
        $endRes = new Carbon($exp->end);

        // return view('portfolio1par.edit', compact('participant', 'exp', 'date', 'calendar', 'datetimes', 'startRes', 'endRes'));
        return view('user.edit', compact('participant', 'exp', 'date', 'calendar', 'datetimes', 'startRes', 'endRes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $participantID)
    {
        //日程の新規追加
        foreach ($request->input('candidate') as $datetime) {
            $priorDate = DB::table('candidates')
                ->select('datetime')
                ->where('participantID', $participantID)
                ->where('expID', $request->input('expID'))
                ->where('datetime', $datetime)
                ->get();
            if ($priorDate->count() === 0) {
                $candiDate = new Candidate;
                $candiDate->expID = $request->input('expID');
                $candiDate->participantID = $participantID;
                $candiDate->datetime = $datetime;
                $candiDate->save();
            }
        }
        //日程の削除
        $priorDate = DB::table('candidates')
            ->select('datetime')
            ->where('participantID', $participantID)
            ->where('expID', $request->input('expID'))
            ->get();
        foreach ($priorDate as $datetime) {
            if (!in_array($datetime->datetime, $request->input('candidate'), true)) {
                $deletingDate = DB::table('candidates')
                    ->where('participantID', $participantID)
                    ->where('expID', $request->input('expID'))
                    ->where('datetime', $datetime->datetime)
                    ->first();
                $deletingDate = Candidate::find($deletingDate->id);
                $deletingDate->delete();
            }
        }
        return redirect('user/index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($participantID, experimentation $exp)
    {
        $deletingDates = DB::table('candidates')
            ->where('participantID', $participantID)
            ->where('expID', $exp->id)
            ->get();
        foreach ($deletingDates as $deletingDate) {
            $candidate = Candidate::find($deletingDate->id);
            $candidate->delete();
        }
        return redirect('user/index');
    }
}