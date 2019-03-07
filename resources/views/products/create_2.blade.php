@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h3>Create Listing</h3>
        </div>
    </div>

    <hr/>

    <form method="post">
        <div class="row mb-4">
            <div class="col-sm-5">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Product Information</h5>

                        <div class="form-group col-sm-12">
                            <label for="product_id">Product ID</label>
                            <input type="text" class="form-control" id="product_id" value="{{ $product->productId }}" disabled>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="company">Company</label>
                            <input type="text" class="form-control" id="company" value="{{ $product->company->name }}" disabled>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $product->title }}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="brand">Brand</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ $product->brand }}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="model">Model</label>
                            <input type="text" class="form-control" id="model" name="model" value="{{ $product->model }}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="sku">SKU</label>
                            <input type="text" class="form-control" id="sku" name="sku" value="{{ $product->sku }}">
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="description">Description</label>
                            <textarea class="form-control" rows="5" id="description" name="description">{{ $product->description }}</textarea>
                        </div>

                        <div class="form-group col-sm-12">
                            <label for="bullets">Bullet Points</label>
                            <textarea class="form-control" rows="5" id="bullets" name="bullets">{{ $product->bullets }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-12">
                        <product-attribute-component :title="'Dimensions'" :attribute-data="'{{ $product->dimensions }}'"></product-attribute-component>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <product-attribute-component :title="'Details'" :attribute-data="'{{ $product->details }}'"></product-attribute-component>
                    </div>
                </div>

            </div>

            <div class="col-sm-2 text-center">
                <image-gallery-component :images="'{{ $product->images }}'"></image-gallery-component>
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
    </form>
@endsection
