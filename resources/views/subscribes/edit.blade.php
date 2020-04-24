@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozás adatainak szerkesztése')}}</div>

                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        {!! Form::open(['action' => ['SubscribesController@update', $subscriber->id], 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{Form::label('name', 'Feliratkozott neve')}}
                                {{Form::text('name', $subscriber->name, [
                                    'class' => 'form-control' . ($errors->has('name')?' is-invalid':''),
                                    'placeholder' => 'név',
                                    'required',
                                ])}}
                                @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('email', 'Feliratkozott e-mail címe')}}
                                {{Form::text('email', $subscriber->email, [
                                    'class' => 'form-control' . ($errors->has('email')?' is-invalid':''),
                                    'placeholder' => 'e-mail',
                                    'required',
                                ])}}
                                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            {{Form::hidden('id', $subscriber->id)}}
                            {{Form::hidden('user_id', $subscriber->fk_id_user)}}
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::submit('Változások mentése', ['class' => 'btn btn-warning'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
