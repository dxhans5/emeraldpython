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
                    <input type="text" class="form-control" id="url" name="url" value="{{ old('url') }}" required>
                </div>
            </div>
        </div>

        <hr/>

        <button class='btn btn-success pt-2' type='submit'>Begin Scrapping</button>
    </form>

    <div class="row mt-4">
        <div class="col-sm-12">

            <div class="panel-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <p class="panel-title"><a data-toggle="collapse" href="#rawDump">Raw Dump</a></p>
                    </div>
                    <div id="rawDump" class="panel-collapse collapse">
                        <div class="panel-body">
                            <pre>TODO: Figure out how to get the full error dump here</pre>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
