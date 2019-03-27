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
            <strong>{{ $error }}</strong></br>
        @endforeach
    </div>
@endif

{{ Session::forget('status') }}
{{ Session::forget('error') }}
{{ Session::forget('errors') }}
