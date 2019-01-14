@extends('layouts.app', ['isAdmin' => true])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Administrator Dashboard</div>

                <div class="card-body">
                    You are logged into the Administration panel!
                </div>
            </div>
        </div>
    </div>
@endsection
