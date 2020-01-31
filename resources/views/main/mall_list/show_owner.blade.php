@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">{{ $owner->mall_owner_name }}
                    <a href="{{ route('mall-owner') }}" style="float: right">Back</a>
                </div>
                <div class="card-body merch_out">
                    @if(isset($malllists))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="{{ route('mall-owner') }}">
                                    <thead>
                                    <th>Mall Owned / Managed</th>
                                    <th>City Name</th>
                                    </thead>
                                    <tbody>
                                    @foreach($malllists as $mall)
                                        <tr class="row-location">
                                            <td>{{ @$mall->mall_name }}
                                            </td>
                                            <td>{{ \App\CityMaster::getCityName(@$mall->city_id) }}</td>
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


