@extends('layouts.app', ['isAdmin' => true])

@section('content')
<div class='row'>
    <div class='col-sm-6'>
        <h1>Create Shipping Service</h1>
    </div>
</div>
<div class='row mt-2'>
    <div class='col-sm-12'>
        <div class="card">
            <div class="card-body">

                    <form action='{{ url("admin/logistics/shipping-service") }}' method='POST'>
                        @csrf

                        <div class="form-group form-inline">
                            <label class="mr-4" for="shipping_carrier_code">Shipping Carrier Code</label>
                            <input type="text" class="form-control" id="shipping_carrier_code">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="shipping_service_code">Shipping Service Code</label>
                            <input type="text" class="form-control" id="shipping_service_code">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="region_included">Region Included</label>
                            <input type="text" class="form-control" id="region_included">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="region_excluded">Region Excluded</label>
                            <input type="text" class="form-control" id="region_excluded">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="additional_shipping_cost">Additional Shipping Cost</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" id="additional_shipping_cost">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="cash_on_delivery_fee">Cash On Delivery Fee</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" id="cash_on_delivery_fee">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="shipping_cost">Shipping Cost</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" id="shipping_cost">
                        </div>

                        <div class="form-group form-inline">
                            <label class="mr-4" for="surcharge">Surcharge</label>
                            <div class="input-group-prepend">
                                <div class="input-group-text">$</div>
                            </div>
                            <input type="text" class="form-control" id="surcharge">
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="buyer_responsible_for_pickup">
                            <label class="form-check-label" for="buyer_responsible_for_pickup">
                                Buyer Responsible For Pickup
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="free_shipping">
                            <label class="form-check-label" for="free_shipping">
                                Free Shipping
                            </label>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="buyer_responsible_for_shipping">
                            <label class="form-check-label" for="buyer_responsible_for_shipping">
                                Buyer Responsible For Shipping
                            </label>
                        </div>


                        <div class='row'>
                            <div class='col-sm-12 text-right'>
                                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Save Shipping Service</button>
                            </div>
                        </div>
                    </form>

            </div>
    </div>
</div>
@endsection
