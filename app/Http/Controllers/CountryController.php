<?php

namespace App\Http\Controllers;

use App\CountryMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = CountryMaster::all();
        $data = [
            'countrys' => $country
        ];

        return view('main.country.country',$data);
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
            'country_name.required'    => 'Country name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'country_name' => 'required|unique:country_master',
            'country_code' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $country = new CountryMaster();
        $country->country_name = $request->country_name;
        $country->country_code = $request->country_code;
        $country->date_added = Carbon::now()->format('d/m/y');
        $country->user_id = Auth::user()->user_id;
        $country->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added Country'),
            'id' => $country->country_id
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
        $tagMaster = CountryMaster::find($id);
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
