@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Policies</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/policies/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Policy</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($policies))
                @foreach($policies as $policy)
                    {{ $policy }}
                @endforeach
            @else
                <p>There are no active policies</p>
            @endif
        </div>
    </div>
@endsection
