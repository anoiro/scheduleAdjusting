@extends('layouts.app')

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

                    <form method="POST" action="{{ route('portfolio1.store') }}">
                        @csrf
                        研究室
                        <select name="labID">
                            <option value="">選択してください</option>
                            @foreach($labs as $lab)
                            <option value="{{ $lab->id }}">{{ $lab->prof }}研究室</option>
                            @endforeach
                        </select>
                        <br>
                        実験名
                        <input type="text" name="expName">
                        <br>
                        実験風景
                        <br>
                        @foreach($labImgs as $labImg)
                        <input type="radio" name="image" value="{{ $labImg->expID }}">
                        <img src='data:img/jpg;base64,<?php print(base64_encode($labImg->img)); ?>' style="width: 50%; height: auto;" />
                        <br>
                        @endforeach
                        開始日
                        <input type="date" name="start">
                        <br>
                        終了予定日
                        <input type="date" name="end">
                        <br>
                        募集人数
                        <input type="number" name="recruit">
                        <br>
                        お礼
                        <input type="radio" name="thanks" value="500">500円/時</input>
                        <input type="radio" name="thanks" value="1000">1,000円/時</input>
                        <input type="radio" name="thanks" value="0">その他</input>
                        <br>
                        会場
                        <input type="text" name="room">
                        <br>

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