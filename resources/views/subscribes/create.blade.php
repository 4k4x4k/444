@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozás a listára')}}</div>

                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        {!! Form::open(['action' => 'SubscribesController@store', 'method' => 'POST']) !!}
                            <div class="form-group">
                                {{Form::label('name', 'Feliratkozó neve')}}
                                {{Form::text('name', '', [
                                    'class' => 'form-control' . ($errors->has('name')?' is-invalid':''),
                                    'placeholder' => 'név',
                                    'required',
                                ])}}
                                @error('name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('email', 'Feliratkozó e-mail címe')}}
                                {{Form::text('email', '', [
                                    'class' => 'form-control' . ($errors->has('email')?' is-invalid':''),
                                    'placeholder' => 'e-mail',
                                    'required',
                                ])}}
                                @error('email') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('user_id', 'Regisztrált felhasználó azonosítója')}}
                                {{Form::text('user_id', auth()->user()->id, [
                                    'class' => 'form-control' . ($errors->has('user_id')?' is-invalid':''),
                                    'placeholder' => 'azonosító',
                                ])}}
                                @error('user_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            {{Form::submit('Feliratkozás', ['class' => 'btn btn-success'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
