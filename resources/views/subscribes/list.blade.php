@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{$title ?? __('Feliratkozások')}}</div>

                    <div class="card-body">
                        @include('inc.messages')

                        @if($subscribes->count())
                            <table class="table table-striped">
                                <tr>
                                    <th>Vezetéknév</th>
                                    <th>Keresztnév</th>
                                    <th>E-mail cím</th>
                                    <th>Felhasználó azonosítója</th>
                                    <th>Feliratkozás dátuma</th>
                                    <th></th>
                                    <th></th>
                                </tr>

                                @foreach($subscribes as $subscriber)
                                    <tr>
                                        <td>{{$subscriber->last_name}}</td>
                                        <td>{{$subscriber->first_name}}</td>
                                        <td>{{$subscriber->email}}</td>
                                        <td>{{$subscriber->fk_id_user}}</td>
                                        <td>{{$subscriber->created_at}}</td>
                                        <td><a href="/subscribes/{{$subscriber->email}}/edit" class="btn btn-warning"><i class="far fa-edit"></i></a></td>
                                        <td>
                                            {!! Form::open(['action' => ['SubscribesController@destroy', $subscriber->email], 'method' => 'POST', 'class' => 'float-right']) !!}
                                            {{Form::hidden('_method', 'DELETE')}}
                                            <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
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
