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

                    {{ $exp->id }}
                    @foreach($labs as $lab)
                    {{ $lab->prof }}研究室
                    @endforeach
                    {{ $exp->expName }}
                    {{ $exp->start }}
                    {{ $exp->end }}
                    {{ $exp->recruit }}
                    {{ $exp->thanks }}
                    {{ $exp->room }}
                    @if($img!=null)
                    <div>
                        <img src='data:img/jpg;base64,<?php print(base64_encode($img->img)); ?>' style="width: 50%; height: auto;" />
                    </div>
                    @endif

                    <form method="GET" action="{{ route('portfolio1.edit', ['id'=>$exp->id]) }}">
                        @csrf
                        <input class="btn btn-info" type="submit" value="変更する">
                    </form>
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
    function deletePost(e){
        'use strict';
        if(confirm('本当に削除していいですか?')){
            document.getElementById('delete_'+e.dataset.id).submit();
        }
    }
</script>

@endsection