@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Products</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/products/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Product</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($products))
                @foreach($products as $product)
                    {{ $product }}
                @endforeach
            @else
                <p>There are no active products</p>
            @endif
        </div>
    </div>
@endsection
