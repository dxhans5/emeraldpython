@extends('layouts.app')

@section('content')
<form method="post" action="{{ url('policies/create') }}">
@csrf
    <div class="row">
        <div class="col-sm-6">
            <h3>Create Policy</h3>
        </div>

        <div class="col-md-6 text-right">
            <button type='submit' class='btn btn-success'><i class="fas fa-save"></i> Save Policy</button>
        </div>
    </div>

    <hr/>


    <div class="row mb-4">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Policy Information</h5>

                    <input type="hidden" class="form-control" id="policy_id" name="policy_id" value="{{ $policy->policy_id }}">

                    <div class="form-group col-sm-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $policy->title }}">
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="shipping" @if($policy->policy_type == 'shipping') selected @endif>Shipping</option>
                            <option value="return" @if($policy->policy_type == 'return') selected @endif>Return</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="5" id="description" name="description">{{ $policy->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@endsection
