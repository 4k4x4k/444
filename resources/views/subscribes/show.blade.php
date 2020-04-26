@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozások')}}</div>

                    <div class="card-body">
                        @include('inc.messages')

                        @if(!empty($subscriber))
                            <h1>
                                @isset($subscriber->fk_id_user) {{"[{$subscriber->fk_id_user}] "}} @endisset
                                {{$subscriber->last_name}} {{$subscriber->first_name}}
                            </h1>
                            <div>{{$subscriber->email}}</div>
                            <small>{{$subscriber->created_at}}</small>

                            @if(Auth::user() && isset($subscriber->fk_id_user) && $subscriber->fk_id_user === auth()->user()->id)
                                {!! Form::open(['action' => ['SubscribesController@destroy', $subscriber->email], 'method' => 'POST', 'class' => 'float-right']) !!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    {{Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger'])}}
                                {!! Form::close() !!}
                                <a href="/subscribes/{{$subscriber->email}}/edit" class="btn btn-warning float-right mr-2"><i class="far fa-edit"></i></a>
                            @endif
                        @else
                            <p>A bejegyzés nem található.</p>
                        @endif
                        <hr>
                        <a href="/subscribes" class="btn btn-light float-left">Vissza a listára</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
