@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">
                    {{__('Manage Inquiry')}}
                </div>

                @if(isset($inquiries))
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
                                @foreach($inquiries as $inquiry)
                                    <tr class="row-location" data-id="{{@$inquiry->inquiry_id}}">
                                        <td>{{ @$inquiry->inquiry_Date }}</td>
                                        <td>{{ @$inquiry->outlet_name }}</td>
                                        <td>{{ @$inquiry->country->country_name }}</td>
                                        <td>{{ @$inquiry->contact_person }}</td>
                                        <td>{{ @$inquiry->contact_number }}</td>
                                        <td>{{ @$inquiry->email_id }}</td>
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
