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

                    <div class="form-group col-sm-12">
                        <label for="company">Company</label>
                        <input type="text" class="form-control" id="company" value="{{ $product->company->name }}" disabled>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="bullets">Bullet Points</label>
                        <textarea class="form-control" rows="5" id="bullets" name="bullets">{{ $product->bullets }}</textarea>
                    </div>

                    <product-attribute-component :title="'Dimensions'" :attribute-data="'{{ $product->dimensions }}'"></product-attribute-component>

                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title"><a data-toggle="collapse" href="#rawDump">Raw Dump</a></p>
                    </div>
                    <div id="rawDump" class="panel-collapse collapse">
                        <div class="panel-body">
                            <pre><?php print_r($product->scrape); ?></pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
