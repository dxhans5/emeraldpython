@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h3>Policies</h3>
        </div>
        <div class="col-md-6 text-right">
            <a href='{{ url("/policies/create") }}'><button type='button' class='btn btn-success'><i class="fas fa-plus"></i> Add Policy</button></a>
        </div>
    </div>

    <hr/>

    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($policies))

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Type</th>
                            <th scope="col">Status</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($policies as $policy)
                            <tr>
                                <td class='title-wrapper'><a href='{{ url("/policies/edit/" . $policy->id) }}'>{{ $policy->title }}</a></td>
                                <td>{{ $policy->policy_type }}</td>
                                <td>{{ $policy->status }}</td>
                                <td>
                                    <a href='{{ url("/policies/toggle-status/" . $policy->id) }}'><span class="@if($policy->status == 'active') red @else green @endif"><i class="fas fa-exchange-alt"></i></span></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <hr/>
                <p>There are no active policies</p>
            @endif
        </div>
    </div>
@endsection
