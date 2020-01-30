<?php

namespace App\Http\Controllers;

use App\CityMaster;
use App\CountryMaster;
use App\MallMaster;
use App\MallOwner;
use Illuminate\Http\Request;

class MallOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = MallOwner::all();
        $citys = CityMaster::all();
        $malls = MallMaster::count();

        $data = [
            'owners' => $owners,
            'citys' => $citys,
            'total_mall' => $malls,
        ];

        return view('main.mall_list.owner',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'mall_owner_name.required'    => 'Company name field is required',
            'city_id.required'    => 'City field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'mall_owner_name' => 'required',
            'city_id' => 'required',


        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $malltype = new MallOwner();
        $malltype->mall_owner_name = $request->mall_owner_name;
        $malltype->city_id = $request->city_id;
        $malltype->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added!'),
            'id' => $malltype->mo_id
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
        $owner = MallOwner::find($id);
        $countrys = CountryMaster::all();
        $cities = CityMaster::all();

        $data = [
            'owner' =>$owner,
            'countries' => $countrys,
            'cities' => $cities,
        ];

        return  view('main.mall_list.edit_mallowner',$data);
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
        $messages = [
            'mall_owner_name.required'    => 'Mall Owner name field is required',
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'mall_owner_name' => 'required',
        ],$messages);

        if($validator->fails()){
            /* return response()->json([
                 'status' => 'error',
                 'message' => $validator->messages()->first()
             ],200);*/

            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        $mall = MallOwner::find($id);
        $mall->mall_owner_name = $request->mall_owner_name ? $request->mall_owner_name : '';
        $mall->country_id = $request->country_id ? $request->country_id : 1;
        $mall->city_id = $request->city_id ? $request->city_id : 1;
        $mall->postal_code = $request->postal_code ? $request->postal_code : 0;
        $mall->telephone = $request->telephone ? $request->telephone : '';
        $mall->company_address = $request->company_address ? $request->company_address : '';
        $mall->website = $request->website ? $request->website : '';
        $mall->facebook = $request->facebook ? $request->facebook : '';
        $mall->instagram = $request->instagram ? $request->instagram : '';
        $mall->twitter = $request->twitter ? $request->twitter : '';
        $mall->youtube = $request->youtube ? $request->youtube : '';
        $mall->save();

        /*return response()->json([
            'status' => 'success',
            'message' => __('successfully updated mall'),
            //'tag_name' => $request->time_name,
            //'id' => $time_master->time_id
        ],200);*/

        return redirect()->route('mall-owner.edit',[$id])->with('success','Updated successfully!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $malltype = MallOwner::find($id);

        $malltype->delete();

        return response()->json([
            'status' => $malltype ? 'success' : 'error',
            'message' => $malltype ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function search($name){
        return MallOwner::search($name);
    }
}
