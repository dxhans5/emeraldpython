@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Categories</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/categories/ebay-update") }}'><button type='button' class='btn btn-warning'><i class="fas fa-wrench"></i> Update Ebay Categories</button></a>
            <a href='{{ url("/categories/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Category</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($categories))

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class='title-wrapper'><a href='{{ url("/categories/edit/" . $category->id) }}'>{{ $category->name }}</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <hr/>
                <p>There are no active categories</p>
            @endif
        </div>
    </div>
@endsection
