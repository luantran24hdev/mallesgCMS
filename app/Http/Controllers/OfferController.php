<?php

namespace App\Http\Controllers;

use App\OfferImages;
use App\OfferMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $offers = OfferMaster::where('mall_id',$id)->get();

        $data = ['offers' => $offers];

        return view('main.offer.index',$data);
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
            'offer_title.required'    => 'Offer Title field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'offer_title' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $offer = new OfferMaster();
        $offer->offer_title = $request->offer_title;
        $offer->offer_desc = '';
        $offer->status = '';
        $offer->featured = 'N';
        $offer->dated = Carbon::now()->format('Y-m-d');
        $offer->start_date = Carbon::now()->format('d/m/Y');
        $offer->no_end_date = '';
        $offer->End_date = Carbon::now()->format('d/m/Y');
        $offer->user_id = \Auth::user()->user_id;
        $offer->live = 'N';
        $offer->mall_id = $request->mall_id;
        $offer->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added offer'),
            //'tag_name' => $request->time_name,
            //'id' => $time_master->time_id
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
        $offer = OfferMaster::find($id);
        $offer_images = OfferImages::where('offer_id',$id)->get();

        $data = [
            'offer' => $offer,
            'offer_images' => $offer_images,
            'live_url' => env('LIVE_URL').'offer_images/'
        ];

        return view('main.offer.edit',$data);
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
            'offer_title.required'    => 'Offer Title field is required',
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'offer_title' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $offer = OfferMaster::find($id);
        $offer->offer_title = $request->offer_title;
        $offer->offer_desc = $request->offer_desc ? $request->offer_desc : "";
        $offer->start_date = $request->start_date;
        $offer->no_end_date = $request->no_end_date ? $request->no_end_date: "";
        $offer->End_date = $request->no_end_date ? "": $request->End_date;
        $offer->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated event'),
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
        $offer_images = OfferImages::where('offer_id',$id)->get();
        foreach ($offer_images as $image){
            if(env('APP_ENV')=='live')
                unlink('../../admin/offer_images/'.$image->Image_name);
            else
                unlink('../storage/app/public/'.$image->Image_name);

            OfferImages::destroy($image->moi_id);
        }

        $offers = OfferMaster::find($id);
        $offers->delete();


        return response()->json([
            'status' => $offers ? 'success' : 'error',
            'message' => $offers ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->offer_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/offer_images/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            $offer = new OfferImages();
            $offer->offer_id = $request->offer_id;
            $offer->mall_id = $request->mall_id;
            $offer->Image_name = $newfilename;
            $offer->user_id = \Auth::user()->user_id;
            $offer->dated = Carbon::now()->format('d-m-Y');
            $offer->count = $request->count;
            $offer->save();


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

        $image = OfferImages::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/offer_images/'.$image->Image_name);
        else
            unlink('../storage/app/public/'.$image->Image_name);

        $delete = OfferImages::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->event_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function columnUpdate(Request $request,$id){

        /*$this->mall->update($id, [
            request()->name => request()->value
        ]);*/
        $name =  $request->name;
        $offer = OfferMaster::find($id);
        $offer->$name = $request->value;
        $offer->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated offer'),
            'id' => $id
        ],200);
    }
}
