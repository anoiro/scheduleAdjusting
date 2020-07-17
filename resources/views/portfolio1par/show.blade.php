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

                    実験ID
                    {{ $exp->id }}
                    <br>
                    <br>
                    研究室
                    {{ $lab->prof }}研究室
                    <br>
                    <br>
                    実験名
                    {{ $exp->expName }}
                    <br>
                    <br>
                    開始日
                    {{ $exp->start }}
                    <br>
                    <br>
                    終了予定日
                    {{ $exp->end }}
                    <br>
                    <br>
                    募集人数
                    {{ $exp->recruit }}
                    <br>
                    <br>
                    お礼
                    {{ $exp->thanks }}
                    <br>
                    <br>
                    会場
                    {{ $exp->room }}
                    <br>
                    <br>
                    @if($img!=null)
                    <div>
                        <img src="data:image/jpg;base64,<?= $img->img ?>" style="width: 50%; height: auto;" />
                    </div>
                    @endif
                    <form method="GET" action="{{ route('portfolio1par.create', ['id'=>$exp->id]) }}">
                        @csrf
                        <input class="btn btn-info" type="submit" value="参加する">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection