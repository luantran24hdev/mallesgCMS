<?php

namespace App\Http\Controllers;

use App\CityMaster;
use App\CompanyMaster;
use App\CountryMaster;
use App\MerchantMaster;
use Illuminate\Http\Request;

class MerchantCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = CompanyMaster::all();
        $citys = CityMaster::all();
        $merchants = MerchantMaster::count();

        $data = [
            'companys' => $company,
            'citys' => $citys,
            'total_merchant' => $merchants,
        ];

        return view('main.merchants_list.company',$data);
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
            'company_name.required'    => 'Company name field is required',
            'city_id.required'    => 'City field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'company_name' => 'required',
            'city_id' => 'required',


        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $malltype = new CompanyMaster();
        $malltype->company_name = $request->company_name;
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
        $merchants = MerchantMaster::where('company_id',$id)->get();
        $company = CompanyMaster::find($id);
        $data = [
            'merchants' => $merchants,
            'company'=>$company,
        ];

        return view('main.merchants_list.show_merchant_owned',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = CompanyMaster::find($id);
        $countrys = CountryMaster::all();
        $cities = CityMaster::all();

        $data = [
            'company' =>$company,
            'countries' => $countrys,
            'cities' => $cities,
        ];

        return  view('main.merchants_list.edit_company',$data);
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
            'company_name.required'    => 'Company name field is required',
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'company_name' => 'required',
        ],$messages);

        if($validator->fails()){
            /* return response()->json([
                 'status' => 'error',
                 'message' => $validator->messages()->first()
             ],200);*/

            return redirect()->back()->withInput()->withErrors($validator->errors());
        }


        $mall = CompanyMaster::find($id);
        $mall->company_name = $request->company_name ? $request->company_name : '';
        $mall->country_id = $request->country_id ? $request->country_id : 1;
        $mall->city_id = $request->city_id ? $request->city_id : 1;
        $mall->postal_code = $request->postal_code ? $request->postal_code : 0;
        $mall->telephone = $request->telephone ? $request->telephone : '';
        $mall->company_address = $request->company_address ? $request->company_address : '';
        $mall->website = $request->website ? $request->website : '';
        $mall->save();

        /*return response()->json([
            'status' => 'success',
            'message' => __('successfully updated mall'),
            //'tag_name' => $request->time_name,
            //'id' => $time_master->time_id
        ],200);*/

        return redirect()->route('merchant-company.edit',[$id])->with('success','Updated successfully!.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $malltype = CompanyMaster::find($id);

        $malltype->delete();

        return response()->json([
            'status' => $malltype ? 'success' : 'error',
            'message' => $malltype ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function search($name){
        return CompanyMaster::search($name);
    }
}
