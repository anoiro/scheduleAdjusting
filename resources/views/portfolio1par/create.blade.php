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

                    <form method="POST" action="">
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