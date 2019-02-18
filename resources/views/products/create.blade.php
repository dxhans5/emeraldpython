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

                <div class="form-group row pt-1 mb-0">
                    <label for="url" class="col-sm-1 col-form-label">URL</label>
                    <div class="col-sm-11">
                        <input type="text" class="form-control" id="url" name="url" required>
                    </div>
                </div>
            </div>
        </div>

        <hr/>

        <button class='btn btn-success pt-2' type='submit'>Begin Scrapping</button>
    </form>
@endsection
