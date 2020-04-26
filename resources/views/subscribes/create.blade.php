@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozás a listára')}}</div>

                    <div class="card-body">
                        @include('inc.messages')

                        {!! Form::open(['action' => 'SubscribesController@store', 'method' => 'POST']) !!}

                            <div class="form-group">
                                {{Form::label('last_name', 'Vezetéknév')}}
                                {{Form::text('last_name', '', [
                                    'class' => 'form-control' . ($errors->has('last_name')?' is-invalid':''), 'placeholder' => 'vezetéknév'])}}
                                @error('last_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('first_name', 'Keresztnév')}}
                                {{Form::text('first_name', '', [
                                    'class' => 'form-control' . ($errors->has('first_name')?' is-invalid':''), 'placeholder' => 'keresztnév'])}}
                                @error('first_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
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

                            {{--  -- }}
                            <div class="form-group">
                                {{Form::label('user_id', 'Regisztrált felhasználó azonosítója')}}
                                {{Form::text('user_id', auth()->user()->id, [
                                    'class' => 'form-control' . ($errors->has('user_id')?' is-invalid':''),
                                    'placeholder' => 'azonosító',
                                ])}}
                                @error('user_id') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>
                            {{--  --}}

                            {{Form::button('<i class="far fa-plus-square"></i> Feliratkozás', ['type' => 'submit', 'class' => 'btn btn-success'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
