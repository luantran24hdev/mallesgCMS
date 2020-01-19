@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Shoppers')}}
                </div>

                    @if(isset($shoppers))
                        <br/>
                        <div class="row container">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table" id="preference-tag-table"
                                       data-sourceurl="{{ route('manage.inquiry') }}">
                                    <thead>
                                        <th>Registered On</th>
                                        <th>Full Name</th>
                                        <th>Gender</th>
                                        <th>Mobile #</th>
                                        <th>Email ID</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody>
                                    @foreach($shoppers as $shopper)
                                        <tr class="row-location" data-id="{{@$shopper->Shopper_id}}">
                                            <td>{{ @$shopper->Registered_on }}</td>
                                            <td>{{ @$shopper->Shopper_name }}</td>
                                            <td>{{ \App\User::getGender(@$shopper->Gender) }}</td>
                                            <td>{{ @$shopper->Mobile_number }}</td>
                                            <td>{{ @$shopper->Email_id }}</td>
                                            <td><a href="{{ route('manage.edit.shoppers',$shopper->Shopper_id) }}"> Edit </a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>


@endsection
