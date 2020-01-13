<?php

namespace App\Http\Controllers;

use App\EventCategory;
use App\EventImages;
use App\EventMaster;
use App\MallMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->get('id');
        $events = EventMaster::where('mall_id',$id)->get();
        $mall = MallMaster::find($id);

        $data = ['events' => $events,
        'mall' => $mall];
        //return $mall;
        return view('main.event.index',$data);
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
            'event_name.required'    => 'Event name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'event_name' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $event = new EventMaster();
        $event->event_name = $request->event_name;
        $event->event_description = '';
        $event->type = 'U';
        $event->featured = 'N';
        $event->mall_id = $request->mall_id;
        $event->start_date = '';
        $event->end_date = '';
        $event->just_1_day = '';
        $event->daily = '';
        $event->event_timing = '';
        $event->all_day	 = '';
        $event->location	 = '';
        $event->event_group_id	 = 0;
        $event->Open_to	 = '';
        $event->user_id = \Auth::user()->user_id;
        $event->created_on = Carbon::now()->format('d/m/Y');
        $event->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added event'),
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
        $event = EventMaster::find($id);
        $event_images = EventImages::where('event_id',$id)->get();
        $events_category = EventCategory::all();

        $data = [
            'event' => $event,
            'events_categorys' =>$events_category,
            'event_images' => $event_images,
            'live_url' => env('LIVE_URL').'event_photos/'
        ];

        return view('main.event.edit',$data);
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
            'event_name.required'    => 'Event name field is required',
            'ec_id.required'    => 'Category field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'event_name' => 'required',
            'ec_id' => 'required'
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $event = EventMaster::find($id);
        $event->event_name = $request->event_name;
        $event->ec_id = $request->ec_id;
        $event->event_description = $request->event_description ? $request->event_description : "";
        $event->start_date = $request->start_date;
        $event->end_date = $request->no_end_date ? "": $request->end_date;
        $event->just_1_day = $request->just_1_day ? $request->just_1_day: "";
        $event->event_timing = $request->event_timing ? $request->event_timing: "";
        $event->all_day	 = $request->all_day ? $request->all_day: "";
        $event->location = $request->location ? $request->location: "";
        $event->save();

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
        $event_image = EventImages::where('event_id',$id)->get();

        foreach ($event_image as $image){

            if(env('APP_ENV')=='live')
                unlink('../../admin/event_photos/'.$image->event_image);
            else
                unlink('../storage/app/public/'.$image->event_image);

            EventImages::destroy($image->event_image_id);
        }


        $events = EventMaster::find($id);
        $events->delete();


        return response()->json([
            'status' => $events ? 'success' : 'error',
            'message' => $events ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->event_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/event_photos/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            $event = new EventImages();
            $event->event_id = $request->event_id;
            $event->event_image = $newfilename;
            $event->user_id = \Auth::user()->user_id;
            $event->event_count = $request->event_count;
            $event->save();


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

        $image = EventImages::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/event_photos/'.$image->event_image);
        else
            unlink('../storage/app/public/'.$image->event_image);

        $delete = EventImages::destroy($id);
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
        $event = EventMaster::find($id);
        $event->$name = $request->value;
        $event->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated event'),
            'id' => $id
        ],200);
    }

}
