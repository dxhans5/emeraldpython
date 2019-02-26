@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h3>Create Listing</h3>
        </div>
    </div>

    <hr/>

    <form method='post'>
        @csrf

        <div class='card'>
            <div class='card-body'>
                <h5 class='card-title'>Item Scraper</h5>

                <hr/>

                <div class="form-group">
                    <label for="company">Company</label>
                    <select class="form-control" id="company" name="companyId">
                        @foreach($companies as $company)
                        <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="url">URL</label>
                    <input type="text" class="form-control" id="url" name="url" required>
                </div>
            </div>
        </div>

        <hr/>

        <button class='btn btn-success pt-2' type='submit'>Begin Scrapping</button>
    </form>
@endsection
