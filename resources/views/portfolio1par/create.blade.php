@extends('layouts.user.app')

@section('content')
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

                    <form method="POST" action="{{ route('portfolio1par.store', ['id'=>$participant->id]) }}">
                        @csrf
                        学籍番号
                        <br>
                        <label><input type="radio" name="studentNumber" value="{{ $participant->studentNumber }}">{{ $participant->studentNumber }}</input>
                        <br>
                        <br>
                        氏名
                        <br>
                        <label><input type="radio" name="name" value="{{ $participant->name }}">{{ $participant->name }}</input>
                        <br>
                        <br>
                        性別
                        <br>
                        <label><input type="radio" name="gender" value="{{ $participant->gender }}">{{ $participant->gender }}</input>
                        <br>
                        <br>
                        年齢
                        <br>
                        <label><input type="radio" name="age" value="{{ $participant->age }}">{{ $participant->age }}歳</input>
                        <br>
                        <br>
                        メールアドレス
                        <br>
                        <label><input type="radio" name="email" value="{{ $participant->email }}">{{ $participant->email }}</input>
                        <br>
                        <br>
                        実験名
                        <br>
                        <label><input type="radio" name="expID" value="{{ $exp->id }}">{{ $exp->expName }}</input>
                        <br>
                        <br>

                        参加可能日をお選びください
                        @if($exp->weekend===1) <br>※土日は募集していません @endif

                        <?php foreach ($calendars as $calendar) : ?>
                            <div class="calender">
                                <table class="table">
                                    <tr>
                                        <th colspan="7">
                                            <div class="text-center">
                                                {{ $start->year }}年{{ $start->month }}月
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
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+8 hours')->modify('+40 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>1コマ</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+10 hours')->modify('+20 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>2コマ</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+12 hours')->modify('+45 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>3コマ</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+14 hours')->modify('+25 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>4コマ</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+16 hours')->modify('+5 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>5コマ</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+18 hours') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>18:00～19:00</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+18 hours')->modify('+30 minutes') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>18:30～19:30</label>
                                                <br>
                                                <label><input type="checkbox" name="candidate[]" value="{{ $day->modify('+19 hours') }}" @if($exp->weekend===1 and ($day->weekDay() === 0 or $day->weekDay() === 6)) disabled='disabled' @endif @if($day->month===$start->month-1 or $day->month===$start->month+1) disabled='disabled' @endif>19:00～20:00</label>
                                                <br>
                                            </div>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <?php $start->modify('+1 month'); ?>
                        <?php endforeach; ?>

                        <label><input type="checkbox" name="caution" value="1">注意事項に同意する</label>
                        <br>
                        <label><input class="btn btn-info" type="submit" value="登録する"></label>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection