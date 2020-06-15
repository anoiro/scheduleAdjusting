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

                    <form method="POST" action="{{ route('portfolio1par.store') }}">
                        @csrf
                        学籍番号
                        <br>
                        <br>
                        <br>
                        氏名
                        <br>
                        <input type="radio" name="name" value="{{ $participant->name }}">{{ $participant->name }}</input>
                        <br>
                        <br>
                        性別
                        <br>
                        <br>
                        <br>
                        年齢
                        <br>
                        <br>
                        メールアドレス
                        <br>
                        <input type="radio" name="email" value="{{ $participant->email }}">{{ $participant->email }}</input>
                        <br>
                        <br>

                        参加可能日をお選びください
                        <div class="calender">
                            <form class="prev-next-form"></form>
                            <table class="table">
                                <tr>
                                    <th colspan="7">
                                        <div class="text-center">
                                            {{ $date->year }}年{{ $date->month }}月
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
                                            <span class="sun" style="color: red">{{ $day->day }}</span>
                                            @elseif($day->weekDay() === 6)
                                            <span class="sat" style="color:blue;">{{ $day->day }}</span>
                                            @else
                                            <span class="other">{{ $day->day }}</span>
                                            @endif
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}0840">1コマ
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1020">2コマ
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1245">3コマ
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1425">4コマ
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1605">5コマ
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1800">18:00～19:00
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1830">18:30～19:30
                                            <br>
                                            <input type="checkbox" name="{{ $day->day }}candidate" value="{{ $day->day }}1900">19:00～20:00
                                            <br>
                                        </div>
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </table>
                        </div>
                        <input type="checkbox" name="caution" value="1">注意事項に同意する
                        <br>
                        <input class="btn btn-info" type="submit" value="登録する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection