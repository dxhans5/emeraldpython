@extends('layouts.app', ['isAdmin' => true])

@section('content')
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
@endsection
