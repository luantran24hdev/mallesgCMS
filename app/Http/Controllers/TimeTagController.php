<?php

namespace App\Http\Controllers;

use App\TimeGroup;
use App\TimeMaster;
use App\TimeTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimeTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $time_masters = TimeMaster::all();
        $data = [
          'time_groups' => $time_masters
        ];
        return view('main.timetag.time_group',$data);
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
            'time_name.required'    => 'Time name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'time_name' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $time_master = new TimeMaster();
        $time_master->time_name = $request->time_name;
        $time_master->user_id =  Auth::user()->user_id;
        $time_master->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tag'),
            'tag_name' => $request->time_name,
            'id' => $time_master->time_id
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
        $time_master = TimeMaster::find($id);
        $time_master->delete();

        return response()->json([
            'status' => $time_master ? 'success' : 'error',
            'message' => $time_master ? __('succesfully deleted') : __('error deleting')
        ],200);


    }

    public function timeTags(){

        //return "kkk";
        $time_tags = TimeTags::all();
        $data = [
            'time_tags' => $time_tags
        ];
        return view('main.timetag.time_tags',$data);
    }

    public function timeTagStore(Request $request){

        $messages = [
            'tt_name.required'    => 'Time Tag field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'tt_name' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $time_tag = new TimeTags();
        $time_tag->tt_name = $request->tt_name;
        $time_tag->user_id =  Auth::user()->user_id;
        $time_tag->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tag'),
            'tag_name' => $request->tt_name,
            'id' => $time_tag->tt_id
        ],200);
    }

    public function timeTagDestroy($id)
    {
        $time_tag = TimeTags::find($id);
        $time_tag->delete();

        return response()->json([
            'status' => $time_tag ? 'success' : 'error',
            'message' => $time_tag ? __('succesfully deleted') : __('error deleting')
        ],200);


    }


    public function timeTagsGrouping(){

        //return "kkk";
        $time_tag_groups = TimeGroup::all();
        $time_tags = TimeTags::all();
        $time_masters = TimeMaster::all();

        $data = [
            'time_tag_groups' => $time_tag_groups,
            'time_tags' => $time_tags,
            'time_groups' => $time_masters
        ];
        return view('main.timetag.time_tag_group',$data);
    }

    public function timeTagGroupingStore(Request $request){
        $messages = [
            'time_tag.required'    => 'Time Tag field is required',
            'time_group.required'    => 'Time Tag field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'time_group' => 'required',
            'time_tag' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $time_tag = new TimeGroup();
        $time_tag->time_id = $request->time_group;
        $time_tag->tt_id = $request->time_tag;
        $time_tag->user_id =  Auth::user()->user_id;
        $time_tag->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added.'),
        ],200);
    }

    public function timeTagGroupingDestroy($id)
    {
        $time_tag_group = TimeGroup::find($id);
        $time_tag_group->delete();

        return response()->json([
            'status' => $time_tag_group ? 'success' : 'error',
            'message' => $time_tag_group ? __('succesfully deleted') : __('error deleting')
        ],200);


    }
}
