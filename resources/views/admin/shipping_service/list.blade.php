@extends('layouts.app', ['isAdmin' => true])

@section('content')
<div class='row'>
    <div class='col-sm-6'>
        <h1>Shipping Service</h1>
    </div>
    <div class='col-sm-6 text-right'>
        <a href='{{ url("admin/logistics/shipping-service/create") }}'><button type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add Shipping Service</button></a>
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
                @if($shipping_services && $shipping_services->total > 0)
                    @foreach($shipping_services as $shipping_service)
                        <tr>
                            <th scope='row'>{{ $shipping_service }}</th>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <th scope='row'>There are no shipping services to show at this time.</th>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
