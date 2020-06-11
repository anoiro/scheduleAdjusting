<!-- resources/views/layouts/app.blade.phpとして保存 -->
@extends('layouts.user.app')
@section('content')

<style>
    .box-header {
        text-align: center;
        padding: 1em;
        background-color: #3399ff;
        color: #fff;
        font-size: 2em;
    }

    .box-body {
        text-align: center;
    }
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="box">
                <div class="box-header">実験参加フォーム</div>
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>開始日</th>
                            <th>終了予定日</th>
                            <th>実験名</th>
                            {{--<th>大学名</th>--}}
                            <th>研究室</th>
                            <th>募集人数</th>
                            <th>お礼</th>
                            <th>会場</th>
                            <th>詳細</th>
                        </tr>
                        @foreach($exps as $exp)
                        <tr>
                            <td>{{ $exp->start }}</td>
                            <td>{{ $exp->end }}</td>
                            <td>{{ $exp->expName }}</td>
                            <td>{{ $exp->prof }}研究室</td>
                            <td>{{ $exp->recruit }}</td>
                            <td>{{ $exp->thanks }}</td>
                            <td>{{ $exp->room }}</td>
                            <td><a href="{{ route('portfolio1par.show', ['id'=>$exp->id]) }}">詳細を見る</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection