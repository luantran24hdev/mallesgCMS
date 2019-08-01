<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\MerchantLocation;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'mall_id.required'    => 'Invalid mall name!'
        ];

        // Start Validation
        $validator = Validator::make($request->all(), [
            'mall_id' => 'required',
            'merchant_id' => 'required',
            'level_id' => 'required',
            'merchant_location' => 'required',
        ],$messages);
        
        if($validator->fails()){ 
           return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
           ],200);
        }

        $insert = MerchantLocation::create([
            'mall_id' => $request->mall_id,
            'merchant_id' => $request->merchant_id,
            'level_id' => $request->level_id,
            'merchant_location' => $request->merchant_location,
            'location_details' => ""
        ]);

        return response()->json([
            'status' => 'success',
            'mall_name' => $request->mall_name,
            'id' => $insert->id
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
        $delete = MerchantLocation::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
