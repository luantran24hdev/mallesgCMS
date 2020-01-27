<?php

namespace App\Http\Controllers;

use App\CityMaster;
use App\CountryMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $city = CityMaster::all();
        $country = CountryMaster::all();
        $data = [
            'citys' => $city,
            'countrys' => $country,
        ];

        return view('main.country.city',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'city_name.required'    => 'Country name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'city_name' => 'required|unique:city_master',
            'country_id' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $city = new CityMaster();
        $city->city_name = $request->city_name;
        $city->country_id = $request->country_id;
        $city->date_added = Carbon::now()->format('d/m/y');
        $city->user_id = Auth::user()->user_id;
        $city->favourite = 'Y';
        $city->state_id = 0;
        $city->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added Country')
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = CityMaster::find($id);
        $city->delete();

        return response()->json([
            'status' => $city ? 'success' : 'error',
            'message' => $city ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
