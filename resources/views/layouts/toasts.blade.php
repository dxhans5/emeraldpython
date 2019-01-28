@if (Session::has('status'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('status') }}
    </div>
@elseif (Session::has('error'))
    <div class="alert alert-danger" role="alert">
        {{ Session::get('error') }}
    </div>
@elseif (Session::has('errors'))
    <div class="alert alert-danger" role="alert">
        @foreach(Session::get('errors') as $error)
            @foreach($error as $err)
                <strong>({{ $err->errorId }}) {{$err->domain}}->{{$err->category}}: {{$err->message}}</strong></br>
                {{ $err->longMessage }}
            @endforeach
        @endforeach
    </div>
@endif
