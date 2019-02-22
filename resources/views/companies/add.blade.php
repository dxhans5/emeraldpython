@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Add Company</h3>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">

        {!! Form::open(['action' => 'CompanyController@save', 'files' => false]) !!}
        //
        {!! Form::close() !!}

        </div>
    </div>
@endsection
