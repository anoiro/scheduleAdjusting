<!-- resources/views/layouts/app.blade.phpとして保存 -->

@extends('layouts_admin.app')

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
                            <th>大学名</th>
                            <th>研究室</th>
                            <th>お礼</th>
                        </tr>
                        <tr>
                            <th>2020/4/12</th>
                            <th>2020/9/30</th>
                            <th>あいうえお実験</th>
                            <th>あいうえお大学</th>
                            <th>あいうえお研究室</th>
                            <th>時給1,000円</th>
                        </tr>
                        {{--
                        @foreach($exps as $exp)
                        <tr>
                            <td>{{ $exp->start }}</td>
                        <td>{{ $exp->end }}</td>
                        <td>{{ $exp->name }}</td>
                        <td>{{ $exp->university }}</td>
                        <td>{{ $exp->lab }}</td>
                        <td>{{ $exp->thanks }}</td>
                        </tr>
                        @endforeach
                        --}}
                    </table>
                </div>
            </div>
            <div class="box">
                <div class="box-header">アクセスの多かった実験</div>
                <div class="box-body">
                    <table class="table table-striped">
                        <tr>
                            <th>開始日</th>
                            <th>終了予定日</th>
                            <th>実験名</th>
                            <th>大学名</th>
                            <th>研究室</th>
                            <th>お礼</th>
                        </tr>
                        <tr>
                            <th>2020/4/1</th>
                            <th>2020/7/1</th>
                            <th>かきくけこ実験</th>
                            <th>かきくけこ大学</th>
                            <th>かきくけこ研究室</th>
                            <th>時給500円</th>
                        </tr>
                        {{--
                        @foreach($exps as $exp)
                        <tr>
                            <td>{{ $exp->start }}</td>
                        <td>{{ $exp->end }}</td>
                        <td>{{ $exp->name }}</td>
                        <td>{{ $exp->university }}</td>
                        <td>{{ $exp->lab }}</td>
                        <td>{{ $exp->thanks }}</td>
                        </tr>
                        @endforeach
                        --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection