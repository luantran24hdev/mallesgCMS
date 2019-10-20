<?php

namespace App\Http\Controllers;

use App\EventMaster;
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

        $data = ['events' => $events];

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
        $event->start_date = Carbon::now()->format('Y-m-d');
        $event->end_date = Carbon::now()->format('Y-m-d');
        $event->just_1_day = '';
        $event->daily = '';
        $event->event_timing = '';
        $event->all_day	 = '';
        $event->location	 = '';
        $event->event_group_id	 = 0;
        $event->Open_to	 = '';
        $event->user_id = \Auth::user()->user_id;
        $event->created_on = Carbon::now()->format('Y-m-d');
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
        $events = EventMaster::find($id);
        $events->delete();

        return response()->json([
            'status' => $events ? 'success' : 'error',
            'message' => $events ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
