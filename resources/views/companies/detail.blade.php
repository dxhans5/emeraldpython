@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h3>{{ $company -> name }}</h3>
        </div>
    </div>

    <hr/>

    <div class="row">
        <div class="col-sm-6">

        {!! Form::open() !!}
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Company Information</h5>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="name">Company Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $company->name }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="name">Company URL</label>
                        <input type="text" class="form-control" id="url" name="url" value="{{ $company->url }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12">
                        <label for="name">Parser</label>
                        <input type="text" class="form-control" id="parser" name="parser" value="{{ $company->parser }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 text-right">
                        <button type="submit" class="btn btn-primary">Submit</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}

        </div>
    </div>
@endsection
