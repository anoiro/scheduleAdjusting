@extends('layouts.exper.app')

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

                    <form method="POST" action="{{ route('portfolio1.update', ['id'=>$exp->id]) }}">
                        @csrf
                        研究室
                        @foreach($labs as $lab)
                        <select name="labID">
                            <option value="">選択してください</option>
                            @foreach($labIDs as $labID)
                            <option value="{{ $labID->id }}" @if(($lab->id)===($labID->id)) selected @endif>{{ $labID->prof }}研究室</option>
                            @endforeach
                        </select>
                        @endforeach
                        <br>
                        実験名
                        <input type="text" name="expName" value="{{ $exp->expName }}">
                        <br>
                        開始日
                        <input type="date" name="start" value="{{ $exp->start }}">
                        <br>
                        終了予定日
                        <input type="date" name="end" value="{{ $exp->end }}">
                        <br>
                        募集人数
                        <input type="number" name="recruit" value="{{ $exp->recruit }}">
                        <br>
                        お礼
                        <input type="radio" name="thanks" value="500" @if(($exp->thanks)=='500') checked @endif>500円/時
                        <input type="radio" name="thanks" value="1000" @if(($exp->thanks)=='1000') checked @endif>1,000円/時
                        <input type="radio" name="thanks" value="0" @if(($exp->thanks)=='0') checked @endif>その他
                        <br>
                        会場
                        <input type="text" name="room" value="{{ $exp->room }}">
                        <br>

                        @if($img!=null)
                        実験風景
                        <div>
                            <img src='data:img/jpg;base64,<?php print(base64_encode($img->img)); ?>' style="width: 50%; height: auto;" />
                        </div>
                        <br>
                        @endif

                        @if($labImgs!=null)
                        実験風景を選択してください
                        <br>
                        @foreach($labImgs as $labImg)
                        <input type="radio" name="image" value="{{ $labImg->expID }}" @if(($exp->id)===($labImg->expID)) checked @endif>
                        <img src='data:img/jpg;base64,<?php print(base64_encode($labImg->img)); ?>' style="width: 50%; height: auto;" />
                        <br>
                        @endforeach
                        @endif

                        <input type="checkbox" name="caution" value="1">注意事項に同意する
                        <br>
                        <input class="btn btn-info" type="submit" value="更新する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection