@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Inquiry')}}
                </div>

                @if(isset($inquirys))
                    <br/>
                    <div class="row container">
                        <div class="col-md-12">
                            <table class="table table-striped malle-table" id="preference-tag-table"
                                   data-sourceurl="{{ route('manage.inquiry') }}">
                                <thead>
                                    <th>Date</th>
                                    <th>Outlet Name</th>
                                    <th>Country</th>
                                    <th>Contact Person</th>
                                    <th>Contact Number</th>
                                    <th>Email</th>
                                </thead>
                                <tbody>
                                @foreach($inquirys as $inquiry)
                                    <tr class="row-location" data-id="{{@$inquiry->Inquiry_id}}">
                                        <td>{{ @$inquiry->Inquiry_Date }}</td>
                                        <td>{{ @$inquiry->Outlet_name }}</td>
                                        <td>{{ @$inquiry->country->country_name }}</td>
                                        <td>{{ @$inquiry->Contact_person }}</td>
                                        <td>{{ @$inquiry->Contact_number }}</td>
                                        <td>{{ @$inquiry->Email_id }}</td>
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


@endsection
