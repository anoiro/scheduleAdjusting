@extends('layouts.exper.app')

@section('content')

<style>
    table {
        width: 100%;
        table-layout: fixed;
    }

    label,
    input[type='checkbox'] {
        cursor: pointer;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('portfolio1.storeDate') }}">
                        @csrf
                        研究室
                        <input type="radio" name="labID" value='{{ $lab->id }}'>{{ $lab->prof }}研究室
                        <br>
                        実験名
                        <input type="radio" name="expID" value='{{ $exp->id }}'>{{ $exp->expName }}
                        <br>
                        @dd($img->id)
                        実験風景
                        <input type="radio" name="imageID" value='{{ $img->id }}'>
                        <br>
                        @if($img!=null)
                        <div>
                            <img src='data:img/jpg;base64,<?php print(base64_encode($img->img)); ?>' style="width: 50%; height: auto;" />
                        </div>
                        @endif
                        <br>
                        開始日
                        <input type="radio" name="start" value="{{ $exp->start }}">{{ $exp->start }}
                        <br>
                        終了予定日
                        <input type="radio" name="end" value="{{ $exp->end }}">{{ $exp->end }}
                        <br>
                        募集人数
                        <input type="radio" name="recruit" value="{{ $exp->recruit }}">{{ $exp->recruit }}
                        <br>
                        お礼
                        <input type="radio" name="thanks" value="{{ $exp->thanks }}">{{ $exp->thanks }}
                        <br>
                        会場
                        <input type="radio" name="room" value="{{ $exp->room }}">{{ $exp->room }}
                        <br>
                        休日の募集
                        <input type="radio" name="weekend" value="{{ $exp->weekend }}">@if($exp->weekend===1) 土日も募集する @else 土日は募集しない @endif
                        <br>

                        <?php foreach ($calendars as $calendar) : ?>
                            <div class="calender">
                                <table class="table">
                                    <tr>
                                        <th colspan="7">
                                            <div class="text-center">
                                                {{ $start1->year }}年{{ $start1->month }}月
                                            </div>
                                        </th>
                                    </tr>

                                    <tr>
                                        <th class="sun" style="color: red">
                                            <div class="text-center">日</div>
                                        </th>
                                        <th class="mon">
                                            <div class="text-center">月</div>
                                        </th>
                                        <th class="tue">
                                            <div class="text-center">火</div>
                                        </th>
                                        <th class="wed">
                                            <div class="text-center">水</div>
                                        </th>
                                        <th class="thu">
                                            <div class="text-center">木</div>
                                        </th>
                                        <th class="fri">
                                            <div class="text-center">金</div>
                                        </th>
                                        <th class="sat" style="color: blue">
                                            <div class="text-center">土</div>
                                        </th>
                                    </tr>

                                    @foreach ($calendar as $week)
                                    <tr>
                                        @foreach ($week as $day)
                                        <td>
                                            <div class="text-center">
                                                @if($day->weekDay() === 0)
                                                <span class="sun" style="color:red;">{{ $day->day }}</span>
                                                @elseif($day->weekDay() === 6)
                                                <span class="sat" style="color:blue;">{{ $day->day }}</span>
                                                @else
                                                <span class="other">{{ $day->day }}</span>
                                                @endif
                                                <br>
                                                @foreach($candidates as $candidate)
                                                @if($day->modify('+8 hours')->modify('+40 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の1コマ</label>
                                                <br>
                                                @elseif($day->modify('+10 hours')->modify('+20 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の2コマ</label>
                                                <br>
                                                @elseif($day->modify('+12 hours')->modify('+45 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の3コマ</label>
                                                <br>
                                                @elseif($day->modify('+14 hours')->modify('+25 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の4コマ</label>
                                                <br>
                                                @elseif($day->modify('+16 hours')->modify('+5 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の5コマ</label>
                                                <br>
                                                @elseif($day->modify('+18 hours')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の18:00~19:00</label>
                                                <br>
                                                @elseif($day->modify('+18 hours')->modify('+30 minutes')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の18:30~19:30</label>
                                                <br>
                                                @elseif($day->modify('+19 hours')==$candidate->datetime)
                                                <label><input type="radio" onclick="fnc(this);" name="confirms[{{ $candidate->participantID }}][]" value="{{ $candidate->id }}">{{ $participants[$candidate->participantID]->studentNumber }}<br>の19:00~20:00</label>
                                                <br>
                                                @endif
                                                @endforeach
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <?php $start1->modify('+1 month'); ?>
                        <?php endforeach; ?>

                        <input type="checkbox" name="caution" value="1">注意事項に同意する
                        <br>

                        <input class="btn btn-info" type="submit" value="登録する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var nowVal;

    function fnc(obj) {
        if (nowVal == obj.value) {
            obj.checked = false;
            nowVal = "";
        } else {
            nowVal = obj.value;
        }
    }
</script>

@endsection