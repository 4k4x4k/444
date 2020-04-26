@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozás adatainak szerkesztése')}}</div>

                    <div class="card-body">
                        @include('inc.messages')

                        {!! Form::open(['action' => ['SubscribesController@update', $subscriber->email], 'method' => 'POST']) !!}

                            <div class="form-group">
                                {{Form::label('last_name', 'Vezetéknév')}}
                                {{Form::text('last_name', $subscriber->last_name, [
                                    'class' => 'form-control' . ($errors->has('last_name')?' is-invalid':''), 'placeholder' => 'vezetéknév'])}}
                                @error('last_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
                            </div>

                            <div class="form-group">
                                {{Form::label('first_name', 'Keresztnév')}}
                                {{Form::text('first_name', $subscriber->first_name, [
                                    'class' => 'form-control' . ($errors->has('first_name')?' is-invalid':''), 'placeholder' => 'keresztnév'])}}
                                @error('first_name') <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span> @enderror
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

                            {{-- {{Form::hidden('user_id', $subscriber->fk_id_user)}} --}}
                            {{Form::hidden('_method', 'PUT')}}
                            {{Form::button('<i class="far fa-edit"></i> Változások mentése', ['type' => 'submit', 'class' => 'btn btn-warning'])}}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
@endsection
