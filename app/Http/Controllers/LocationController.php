<?php

namespace App\Http\Controllers;

use App\MerchantLocationImages;
use Carbon\Carbon;
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
    public function edit(Request $request, $id)
    {
        $merchant_id = $request->mid;
        $location = MerchantLocation::find($id);
        $locations_images = MerchantLocationImages::where('merchantlocation_id',$id)->where('merchant_id',$merchant_id)->get();

       // return $locations_images;
        $data = [
            'location' => $location,
            'locations_images' => $locations_images,
            'live_url' => env('LIVE_URL').'location_images/'
        ];
        return view('main.merchants.merchant_locations_images',$data);
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

    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->merchantlocation_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/location_images/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            $image = new MerchantLocationImages();
            $image->merchantlocation_id = $request->merchantlocation_id;
            $image->merchant_id = $request->merchant_id;
            $image->image = $newfilename;
            $image->user_id = \Auth::user()->user_id;
            $image->image_count = $request->count;
            $image->date = Carbon::now();
            $image->save();


        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }

        return response()->json([
            'status' => 'success' ,
            'message' =>__('succesfully uploaded'),
            'file' => env("LIVE_URL").$newfilename
        ],200);

    }

    public function deleteimage($id){

        $image = MerchantLocationImages::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/location_images/'.$image->image);
        else
            unlink('../storage/app/public/'.$image->image);

        $delete = MerchantLocationImages::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->event_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

}
