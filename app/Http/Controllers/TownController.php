<?php

namespace App\Http\Controllers;

use App\CityMaster;
use App\CountryMaster;
use App\TownMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $town = TownMaster::all();
        $city = CityMaster::all();
        $data = [
            'towns' => $town,
            'citys' => $city,
        ];

        return view('main.country.town',$data);
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
            'town_name.required'    => 'Country name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'town_name' => 'required|unique:town_master',
            'city_id' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $town = new TownMaster();
        $town->town_name = $request->town_name;
        $town->city_id = $request->city_id;
        $town->date_added = Carbon::now()->format('d/m/y');
        $town->user_id = Auth::user()->user_id;
        $town->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added Country'),
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
        $city = TownMaster::find($id);
        $city->delete();

        return response()->json([
            'status' => $city ? 'success' : 'error',
            'message' => $city ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
