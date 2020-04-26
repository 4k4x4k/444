@if (Session::has('success') || Session::has('error'))
    <div class="alert alert-{{(Session::has('success')?'success':'danger')}} alert-dismissible fade show" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        @if (Session::has('success'))
            {{Session::get('success')}}
        @else
            @if (is_array(Session::get('error')))
                @if (count(Session::get('error')) > 1)
                    <ul>
                        @foreach (Session::get('error') as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @else
                    {{current(Session::get('error'))}}
                @endif
            @else
                {{Session::get('error')}}
            @endif
        @endif
    </div>
@endif
