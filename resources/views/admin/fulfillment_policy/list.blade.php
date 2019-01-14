@extends('layouts.app', ['isAdmin' => true])

@section('content')
<table class='table'>
    <thead class='thead-dark'>
        <tr>
            <th scope='col'>...</th>
        </tr>
    </thead>
    <tbody>
        @if(sizeof($policies) > 0)
            @for ($i = 0; $i < sizeof($policies); $i++)
                <tr>
                    <th scope='row'>{{ $policies[$i] }}</th>
                </tr>
            @endfor
        @else
            <tr>
                <th scope='row'>There are no policies to show at this time.</th>
            </tr>
        @endif
    </tbody>
</table>
@endsection
