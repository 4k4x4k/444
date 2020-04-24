@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Ellenőrizd az e-mail postafiókodat!') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Elküldtünk egy új ellenőrző linket az e-mail címedre.') }}
                        </div>
                    @endif

                    {{ __('Kérlek ellenőrizd, hogy megkaptad-e az ellenőrző linket tartalmazó e-mailt!') }}
                    {{ __('Ha nem kaptad meg az e-mailt,') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('kattints ide az újraküldéshez!') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
