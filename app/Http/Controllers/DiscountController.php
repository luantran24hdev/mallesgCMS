<?php

namespace App\Http\Controllers;

use App\TagMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags_master = TagMaster::all();
        $data = [
            'tags_master' => $tags_master
        ];

        return view('main.discount_tag.discount_tags',$data);
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
            'tag_name.required'    => 'Tag name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'tag_name' => 'required|unique:tags_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $tag_master = new TagMaster();
        $tag_master->tag_name = $request->tag_name;
        $tag_master->dated = Carbon::now()->format('d-m-Y');
        $tag_master->user_id = \Auth::user()->user_id;
        $tag_master->image = '';
        $tag_master->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tags'),
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
        $tagMaster = TagMaster::find($id);

        $data = [
            'tagMaster' => $tagMaster,
            'live_url' => env('LIVE_URL').'tag_images/'
        ];

        return view('main.discount_tag.edit_tags',$data);

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
        //return $request->all();
        $messages = [
            'tag_name.required'    => 'Tag name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'tag_name' => 'required|unique:tags_master,tag_name,'.$id.',tag_id',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $tag_master = TagMaster::find($id);
        $tag_master->tag_name = $request->tag_name;
        $tag_master->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully Updated tags'),
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
        $tagMaster = TagMaster::find($id);
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function search($name){
        return TagMaster::search($name);
    }


    public function uploadimage(Request $request)
    {
        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->tag_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/tag_images/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = TagMaster::find($request->tag_id);
            $tag->image = $newfilename;
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

        $image = TagMaster::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/tag_images/'.$image->image);
        else
            unlink('../storage/app/public/'.$image->image);

        $image->image = '';
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
