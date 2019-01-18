@extends('layouts.app', ['isAdmin' => true])

@section('content')
<div class='row'>
    <div class='col-sm-6'>
        <h1>Fulfillment Policies</h1>
    </div>
    <div class='col-sm-6 text-right'>
        <a href='{{ url("admin/account/fulfillment-policy/create") }}'><button type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add Fulfillment Policy</button></a>
    </div>
</div>
<div class='row mt-2'>
    <div class='col-sm-12'>
        <table class='table'>
            <thead class='thead-dark'>
                <tr>
                    <th scope='col'>...</th>
                </tr>
            </thead>
            <tbody>
                @if($policies->total > 0)
                    @foreach($policies->fulfillmentPolicies as $policy)
                        <tr>
                            <th scope='row'>{{ $policy }}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th scope='row'>There are no policies to show at this time.</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
