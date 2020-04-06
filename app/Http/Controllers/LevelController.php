<?php

namespace App\Http\Controllers;

use App\LevelMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $level_master = LevelMaster::all();
        $data = [
            'level_master' => $level_master,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.level.index',$data);
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
            'level.required'    => 'Level name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'level' => 'required|unique:level_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $level = new LevelMaster();
        $level->level = $request->level;
        $level->created_on = Carbon::now()->format('d/m/Y');
        $level->created_by = \Auth::user()->user_id;
        $level->level_image = null;
        $level->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added'),
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
        $level = LevelMaster::find($id);

        $data = [
            'level' => $level,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.level.edit',$data);
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
            'level.required'    => 'Level name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'level' => 'required|unique:level_master,level,'.$id.',level_id',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $level = LevelMaster::find($id);
        $level->level = $request->level;
        $level->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully Updated'),
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
        $tagMaster = LevelMaster::find($id);
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function uploadimage(Request $request)
    {
        $file = $request->files->get('file');
        try{

            if($file->getMimeType()!="image/png" && $file->getMimeType()!="image/jpeg" && $file->getMimeType()!="image/jpg"){
                throw new \Exception("invalid file", 500);
            }



            $newfilename = md5($request->level_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = LevelMaster::find($request->level_id);
            $tag->level_image = $newfilename;
            $tag->save();


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

        $image = LevelMaster::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/stock/'.$image->level_image);
        else
            unlink('../storage/app/public/'.$image->level_image);

        $image->level_image = '';
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
