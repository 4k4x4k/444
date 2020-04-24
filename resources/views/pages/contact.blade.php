@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{$title}}</h1>

        @if(!empty($info))
            <dl class="row">
                @foreach($info as $i)
                    <dt class="col-sm-2">{{$i['title']}}</dt>
                    <dd class="col-sm-10">{{$i['value']}}</dd>
                @endforeach
            </dl>
        @endif
    </div>
@endsection
