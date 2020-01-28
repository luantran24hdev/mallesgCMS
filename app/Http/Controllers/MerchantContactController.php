<?php

namespace App\Http\Controllers;

use App\CountryMaster;
use App\MerchantContact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantContactController extends Controller
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
            'contact_person.required'    => 'Contact person field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'contact_person' => 'required',
            'position_held' => 'required',
            'contact_number' => 'required',
            'email_id' => 'required'


        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $country = new MerchantContact();
        $country->merchant_id = $request->merchant_id;
        $country->contact_name = $request->contact_person;
        $country->position_held = $request->position_held;
        $country->contact_number = $request->contact_number;
        $country->email_id = $request->email_id;
        $country->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added!'),
            //'id' => $country->country_id
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
        $mcontact = MerchantContact::where('merchant_id',$id)->get();

        $data = [
            'contacts' => $mcontact,
            'id' => $id
        ];

        return view('main.merchants_list.contact',$data);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $contact = MerchantContact::find($id);

        $data = [
            'contact' => $contact,
        ];

        return view('main.merchants_list.edit_contact',$data);
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
            'contact_person.required'    => 'Contact person field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'contact_person' => 'required',
            'position_held' => 'required',
            'contact_number' => 'required',
            'email_id' => 'required'


        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $country = MerchantContact::find($id);
        $country->contact_name = $request->contact_person;
        $country->position_held = $request->position_held;
        $country->contact_number = $request->contact_number;
        $country->email_id = $request->email_id;
        $country->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully upated!'),
            //'id' => $country->country_id
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tagMaster = MerchantContact::find($id);
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
