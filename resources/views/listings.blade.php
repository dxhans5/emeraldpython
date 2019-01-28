@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Listings</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/listings/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Create Listing</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <h5>Active Listings</h5>

            @if($listings['active_list']->length > 0)
                @foreach($listings['active_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no active listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Sold Listings</h5>

            @if($listings['sold_list']->length > 0)
                @foreach($listings['sold_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no sold listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Unsold Listings</h5>

            @if($listings['unsold_list']->length > 0)
                @foreach($listings['unsold_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no unsold listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Deleted From Sold Listings</h5>

            @if($listings['deleted_from_sold_list']->length > 0)
                @foreach($listings['deleted_from_sold_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no deleted from sold listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Deleted From Unsold Listings</h5>

            @if($listings['deleted_from_unsold_list']->length > 0)
                @foreach($listings['deleted_from_unsold_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no deleted from unsold listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Scheduled Listings</h5>

            @if($listings['scheduled_list']->length > 0)
                @foreach($listings['scheduled_list'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There are no scheduled listings</p>
            @endif
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center pt-2">
        <div class="col-md-12">
            <h5>Summary</h5>

            @if($listings['selling_summary']->length > 0)
                @foreach($listings['selling_summary'] as $listing)
                    {{ $listing }}
                @endforeach
            @else
                <p>There is currently no summary</p>
            @endif
        </div>
    </div>
@endsection
