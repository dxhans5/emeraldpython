@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h3>Create Listing</h3>
        </div>
    </div>

    <hr/>

    <div class="row mb-4">
        <div class="col-sm-6">

            {!! Form::open() !!}
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Information</h5>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" id="company" value="{{ $product->company->name }}" disabled>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}">
                        </div>
                    </div>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Raw Scrape</h5>
                <hr/>
                <pre><?php print_r($product->scrape); ?></pre>
            </div>
        </div>
    </div>
@endsection
