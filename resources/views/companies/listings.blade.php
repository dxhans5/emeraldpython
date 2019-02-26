@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <h3>Companies</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/companies/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Company</button></a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($companies))
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">URL</th>
                        <th scope="col">Parser</th>
                        <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <th scope="row">{{ $company->id }}</th>
                                <td><a href="companies/{{ $company->id }}">{{ $company->name }}</a></td>
                                <td>{{ $company->url }}</td>
                                <td>{{ $company->parser }}</td>
                                <td><a href="companies/delete/{{ $company->id }}"><i class="fas fa-trash red"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>There are no active companies</p>
            @endif
        </div>
    </div>
@endsection
