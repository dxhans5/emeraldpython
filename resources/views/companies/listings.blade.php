@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Companies</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/companies/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Company</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($companies))
                @foreach($companies as $company)
                    {{ $company }}
                @endforeach
            @else
                <p>There are no active companies</p>
            @endif
        </div>
    </div>
@endsection
