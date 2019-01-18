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

                    <form action='{{ url("admin/account/fulfillment-policy") }}' method='POST'>
                        @csrf

                        <div class='row'>
                            <!-- Name of Fulfillment Policy -->
                            <div class='col-sm-4'>
                                <div class="form-group">
                                    <label for="name">Fulfillment Policy Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Handling Time -->
                            <div class='row'>
                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="handlingTimeUnit">Handling Time Unit</label>
                                        <select class="form-control" id="handlingTimeUnit" name="handlingTimeUnit">
                                            <option value='YEAR'>YEAR</option>
                                            <option value='MONTH'>MONTH</option>
                                            <option value='DAY' selected>DAY</option>
                                            <option value='HOUR'>HOUR</option>
                                            <option value='CALENDAR_DAY'>CALENDAR DAY</option>
                                            <option value='BUSINESS_DAY'>BUSINESS DAY</option>
                                            <option value='MINUTE'>MINUTE</option>
                                            <option value='SECOND'>SECOND</option>
                                            <option value='MILLISECOND'>MILLISECOND</option>
                                        </select>
                                    </div>
                                </div>

                                <div class='col-sm-6'>
                                    <div class="form-group">
                                        <label for="handlingTimeValue">Value</label>
                                        <input type="text" class="form-control" id="handlingTimeValue" name="handlingTimeValue">
                                    </div>
                                </div>
                            </div>

                            <!-- Freight/Global Shipping Options -->
                            <div class='col-sm-4'>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="freightShipping" name="freightShipping">
                                    <label class="form-check-label" for="freightShipping">
                                        Freight Shipping
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="globalShipping" name="globalShipping">
                                    <label class="form-check-label" for="globalShipping">
                                        Global Shipping
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-sm-12 text-right'>
                                <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Save Fulfillment Policy</button>
                            </div>
                        </div>
                    </form>

            </div>
    </div>
</div>
@endsection
