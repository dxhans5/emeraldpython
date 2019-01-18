@extends('layouts.app', ['isAdmin' => true])

@section('content')
<div class='row'>
    <div class='col-sm-6'>
        <h1>Create Fulfillment Policy</h1>
    </div>
</div>
<div class='row mt-2'>
    <div class='col-sm-12'>
        <div class="card">
            <div class="card-body">
                <p class="card-text">
                    <form action='{{ url("admin/account/fulfillment-policy") }}' method='POST'>

                        <div class='row'>
                            <div class='col-sm-12 text-right'>
                                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Save Fulfillment Policy</button>
                            </div>
                        </div>
                    </form>
                </p>
            </div>
    </div>
</div>
@endsection
