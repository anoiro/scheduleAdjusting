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

                    <form method="POST" action="{{ route('portfolio1.storeImg') }}" enctype="multipart/form-data">
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
                        <select name="expID">
                            <option value="">選択してください</option>
                            @foreach($exps as $exp)
                            <option value="{{ $exp->id }}">{{ $exp->expName }}</option>
                            @endforeach
                        </select>
                        <br>

                        画像データ
                        <input type="file" name="img">
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