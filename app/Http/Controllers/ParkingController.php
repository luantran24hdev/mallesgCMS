<?php

namespace App\Http\Controllers;

use App\MallMaster;
use App\ParkingImages;
use Illuminate\Http\Request;

class ParkingController extends Controller
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
        //
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
        $parkings = MallMaster::find($id);
        $parking_images = ParkingImages::where('mall_id',$id)->get();
        $data = [
            'parking' => $parkings,
            'parking_images' => $parking_images,
            'live_url' => env('LIVE_URL').'parking_images/'
        ];

        return view('main.parking.edit',$data);
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
        /*$messages = [
            'paid_parking.required'    => 'Paid Parking field is required',
            'free_parking.required'    => 'Free parking field is required',
            'grace_period.required'    => 'Grace Period field is required',
            'total_parking.required'    => 'Parking Spaces field is required',
            'available_parking.required'    => 'Available  now field is required',
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'paid_parking' => 'required',
            'free_parking' => 'required',
            'grace_period' => 'required',
            'total_parking' => 'required',
            'available_parking' => 'required',

        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }*/

        $parking = MallMaster::find($id);
        $parking->no_parking_info = $request->no_parking_info ? $request->no_parking_info : 'N';
        $parking->paid_parking = $request->paid_parking ? $request->paid_parking : '';
        $parking->free_parking = $request->free_parking ? $request->free_parking : '';
        $parking->grace_period = $request->grace_period ? $request->grace_period : '10 Mins';
        $parking->total_parking = $request->total_parking ? $request->total_parking : 0;
        $parking->available_parking = $request->available_parking ? $request->available_parking : 0;
        $parking->featured_park = $request->featured_park;
        $parking->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated parking'),
            //'tag_name' => $request->time_name,
            //'id' => $time_master->time_id
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
        //
    }

    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->mall_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/parking_images/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            $parking = new ParkingImages();
            $parking->mall_id = $request->mall_id;
            $parking->parking_image = $newfilename;
            $parking->image_count = $request->image_count;
            $parking->save();


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

        $image = ParkingImages::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/parking_images/'.$image->parking_image);
        else
            unlink('../storage/app/public/'.$image->parking_image);

        $delete = ParkingImages::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->event_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
