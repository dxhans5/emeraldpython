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

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($products))

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Title</th>
                            <th scope="col">Price</th>
                            <th scope="col">Company</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td></td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->company_id }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <hr/>
                <p>There are no active products</p>
            @endif
        </div>
    </div>
@endsection
