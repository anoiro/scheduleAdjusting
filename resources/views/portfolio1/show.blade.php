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

                    実験ID : 
                    {{ $exp->id }}
                    <br>
                    <br>
                    研究室 : 
                    {{ $lab->prof }}研究室
                    <br>
                    <br>
                    実験名 : 
                    {{ $exp->expName }}
                    <br>
                    <br>
                    開始日 : 
                    {{ $exp->start }}
                    <br>
                    <br>
                    終了予定日 : 
                    {{ $exp->end }}
                    <br>
                    <br>
                    募集人数 : 
                    {{ $exp->recruit }}
                    <br>
                    <br>
                    お礼 : 
                    {{ $exp->thanks }}
                    <br>
                    <br>
                    会場 : 
                    {{ $exp->room }}
                    <br>
                    <br>
                    @if($img!=null)
                    実験風景
                    <div>
                        <img src="data:image/jpg;base64,<?= $img->img ?>" style="width: 50%; height: auto;" />
                    </div>
                    @endif

                    <form method="GET" action="{{ route('portfolio1.edit', ['id'=>$exp->id]) }}">
                        @csrf
                        <input class="btn btn-info" type="submit" value="変更する">
                    </form>
                    @if(($lab->id===$experimenter->labID) and ($candidateCount!=0))
                    <form method='GET' action="{{ route('portfolio1.createDate', ['id'=>$exp->id]) }}">
                        <button type='submit' class='btn btn-success'>
                            参加者一覧
                        </button>
                    </form>
                    @endif
                    <form method="POST" action="{{ route('portfolio1.destroy', ['id'=>$exp->id]) }}" id="delete_{{ $exp->id }}">
                        @csrf
                        <a href="#" class="btn btn-danger" data-id="{{ $exp->id }}" onclick="deletePost(this);">削除する</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function deletePost(e) {
        'use strict';
        if (confirm('本当に削除していいですか?')) {
            document.getElementById('delete_' + e.dataset.id).submit();
        }
    }
</script>

@endsection