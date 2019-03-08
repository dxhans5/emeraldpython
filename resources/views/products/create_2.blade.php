@extends('layouts.app')

@section('content')
<form method="post" action="{{ url('products/submit') }}">
@csrf
    <div class="row">
        <div class="col-sm-6">
            <h3>Create Listing</h3>
        </div>

        <div class="col-md-6 text-right">
            <button type='submit' class='btn btn-success'><i class="fas fa-save"></i> Save Product</button>
        </div>
    </div>

    <hr/>


    <div class="row mb-4">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Product Information</h5>

                    <div class="form-group col-sm-12">
                        <label for="product_id">Product ID</label>
                        <input type="text" class="form-control @if (empty($product->productId)) input-error @endif" id="product_id" value="{{ $product->productId }}" disabled>
                        @if (empty($product->productId))
                            <small class="form-text red">There was a problem creating the product ID.</small>
                        @endif
                        <input type="hidden" name="product_id" value="{{ $product->productId }}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="company">Company</label>
                        <input type="text" class="form-control @if (empty($product->company->name)) input-error @endif" id="company" value="{{ $product->company->name }}" disabled>
                        @if (empty($product->company->name))
                            <small class="form-text red">There was a problem scraping the company name.</small>
                        @endif
                        <input type="hidden" name="company" value="{{ $product->company->name }}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control @if (empty($product->title)) input-error @endif" id="title" name="title" value="{{ $product->title }}">
                        @if (empty($product->title))
                            <small class="form-text red">There was a problem scraping the product title.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="price">Price</label>
                        <input type="text" class="form-control @if (empty($product->dollars) || empty($product->dollars)) input-error @endif" id="price" name="price" value="
                            @if (!empty($product->dollars) && !empty($product->cents))
                                {{ $product->dollars }}.{{ $product->cents }}
                            @endif
                        ">
                        @if (empty($product->dollars))
                            <small class="form-text red">There was a problem scrapping the product dollars.</small>
                        @endif
                        @if (empty($product->cents))
                            <small class="form-text red">There was a problem scrapping the product cents.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="brand">Brand</label>
                        <input type="text" class="form-control @if (empty($product->brand)) input-error @endif" id="brand" name="brand" value="{{ $product->brand }}">
                        @if (empty($product->brand))
                            <small class="form-text red">There was a problem scrapping the product brand.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="model">Model</label>
                        <input type="text" class="form-control @if (empty($product->model)) input-error @endif" id="model" name="model" value="{{ $product->model }}">
                        @if (empty($product->model))
                            <small class="form-text red">There was a problem scrapping the product model.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control @if (empty($product->sku)) input-error @endif" id="sku" name="sku" value="{{ $product->sku }}">
                        @if (empty($product->sku))
                            <small class="form-text red">There was a problem scrapping the product sku.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="description">Description</label>
                        <textarea class="form-control @if (empty($product->description)) input-error @endif" rows="5" id="description" name="description">{{ $product->description }}</textarea>
                        @if (empty($product->description))
                            <small class="form-text red">There was a problem scrapping the product description.</small>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="bullet_points">Bullet Points</label>
                        <textarea class="form-control @if (empty($product->bullets)) input-error @endif" rows="5" id="bullet_points" name="bullet_points">{{ $product->bullets }}</textarea>
                        @if (empty($product->bullets))
                            <small class="form-text red">There was a problem scrapping the product bullets.</small>
                        @endif
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
