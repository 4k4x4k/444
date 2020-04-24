@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h1 class="mt-5 mb-5 text-center">
                            Üdvözlünk a {{config('app.name', '!!444!!!')}} weboldalán! :)
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
