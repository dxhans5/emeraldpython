@extends('layouts.app')

@section('content')
<form method="post" action="{{ url('categories/create') }}">
@csrf
    <div class="row">
        <div class="col-sm-6">
            <h3>Create Category</h3>
        </div>

        <div class="col-md-6 text-right">
            <button type='submit' class='btn btn-success'><i class="fas fa-save"></i> Save Category</button>
        </div>
    </div>

    <hr/>

    Form goes here
</form>

@endsection
