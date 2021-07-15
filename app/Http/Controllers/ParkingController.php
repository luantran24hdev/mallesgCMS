<?php

namespace App\Http\Controllers;

use App\MallMaster;
use App\ParkingImages;
use App\ParkingMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $parking = ParkingMaster::where('mall_id', $id)->first();
        $mall = MallMaster::where('mall_id', $id)->first();
        $parking_images = ParkingImages::where('mall_id', $id)->get();
        $data = [
            'mall' => $mall,
            'parking' => $parking,
            'parking_images' => $parking_images,
            'live_url' => env('LIVE_URL') . 'images/parking/'
        ];

        return view('main.parking.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
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

//        $parking = ParkingMaster::where('parking_id', $id)->first();
//        if(!$parking)
//            $parking = new ParkingMaster();

        $parking = ParkingMaster::updateOrcreate(
            [
                'mall_id' => $id,
            ],
            [
                'views' => $request->views,
                'featured' => $request->featured,
                'lots_cars' => $request->lots_cars,
                'lots_bike' => $request->lots_bike,
                'lots_handicap' => $request->lots_handicap,
                'lots_ev' => $request->lots_ev,
                'lots_family' => $request->lots_family,
                'car_park_info' => $request->car_park_info,
                'grace_period' => $request->grace_period,
                'operating_hours' => $request->operating_hours,
                '24_hours' => $request['24_hours']? 'Y': 'N',
                'free_parking' => $request->free_parking,
                'car_charges' => $request->car_charges,
                'bike_charges' => $request->bike_charges,
                'car_park_info' => $request->car_park_info,
                'dated' => Carbon::now()->format('d/m/Y'),
                'user_id' => Auth::id(),
            ]);



        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated parking'),
            //'tag_name' => $request->time_name,
            //'id' => $time_master->time_id
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try {

            if ($file->getMimeType() != "image/png") {
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->mall_id . "_" . round(microtime(true))) . '.png';

            if (env('APP_ENV') == 'live')
                $file->move('../../admin/images/parking/', $newfilename);
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
            'status' => 'success',
            'message' => __('succesfully uploaded'),
            'file' => env("LIVE_URL") . $newfilename
        ], 200);

    }

    public function deleteimage($id)
    {

        $image = ParkingImages::find($id);

        if (env('APP_ENV') == 'live')
            unlink('../../admin/images/parking/' . $image->parking_image);
        else
            unlink('../storage/app/public/' . $image->parking_image);

        $delete = ParkingImages::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->event_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ], 200);
    }
}
