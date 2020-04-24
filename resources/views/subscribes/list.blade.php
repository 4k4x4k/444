@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozások')}}</div>

                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if($subscribes->count())
                            <table class="table table-striped">
                                <tr>
                                    <th>Feliratkozó neve</th>
                                    <th>Feliratkozó e-mail címe</th>
                                    <th>Feliratkozó felhasználó azonosítója</th>
                                    <th>Feliratkozás dátuma</th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                @foreach($subscribes as $subscriber)
                                    <tr>
                                        <td>{{$subscriber->name}}</td>
                                        <td>{{$subscriber->email}}</td>
                                        <td>{{$subscriber->fk_id_user}}</td>
                                        <td>{{$subscriber->created_at}}</td>
                                        <td><a href="/subscribes/{{$subscriber->id}}/edit" class="btn btn-warning"><i class="fas fa-edit"></a></td>
                                        <td>
                                            {!! Form::open(['action' => ['SubscribesController@destroy', $subscriber->id], 'method' => 'POST', 'class' => 'float-right']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {{ $subscribes->links() }}
                        @else
                            Nincsenek feliratkozók.
                        @endif
                        <div><a href="/subscribes/create" class="btn btn-success"><i class="far fa-plus-square"></i> Új feliratkozás létrehozása</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
