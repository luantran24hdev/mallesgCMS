@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-malle">
                <div class="card-header-malle">{{ $company->company_name }}
                    <a href="{{ route('merchant-company') }}" style="float: right">Back</a>
                </div>
                <div class="card-body merch_out">
                    @if(isset($merchants))
                        <br/>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped malle-table"  id="mall_type-table"
                                       data-sourceurl="{{ route('merchant-company') }}">
                                    <thead>
                                    <th>Merchant Owned / Managed</th>
                                    <th>City Name</th>
                                    </thead>
                                    <tbody>
                                    @foreach($merchants as $merchant)
                                        <tr class="row-location">
                                            <td>{{ @$merchant->merchant_name }}
                                            </td>
                                            <td>{{ \App\CityMaster::getCityName(@$merchant->city_id) }}</td>
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


