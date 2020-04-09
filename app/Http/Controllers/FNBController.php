<?php

namespace App\Http\Controllers;

use App\FNBCategory;
use App\FNBType;
use App\SubCategoryMaster;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FNBController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fnb_cats = FNBCategory::all();
        $fnb_types = FNBType::all();
        $data = [
            'fnb_cats' => $fnb_cats,
            'fnb_types' => $fnb_types,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.fnb_list.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            'fnb_name.required'    => 'Dish name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'fnb_name' => 'required|unique:f_n_b_category',
            'fnb_type' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $fnb = new FNBCategory();
        $fnb->fnb_name = $request->fnb_name;
        $fnb->fnb_type = $request->fnb_type;
        $fnb->fnb_image = null;
        $fnb->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added FNB'),
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
        $tagMaster = FNBCategory::find($id);

        if(!empty($tagMaster->fnb_image)){
            if(env('APP_ENV')=='live')
                unlink('../../admin/images/stock/'.$tagMaster->fnb_image);
            else
                unlink('../storage/app/public/'.$tagMaster->fnb_image);
        }

        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function search($name){
        return FNBCategory::search($name);
    }

    public function uploadimage(Request $request)
    {
        $file = $request->files->get('file');
        try{

            if($file->getMimeType()!="image/png" && $file->getMimeType()!="image/jpeg" && $file->getMimeType()!="image/jpg"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->fnb_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = FNBCategory::find($request->fnb_id);
            $tag->fnb_image = $newfilename;
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

        $image = FNBCategory::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/stock/'.$image->fnb_image);
        else
            unlink('../storage/app/public/'.$image->fnb_image);

        $image->fnb_image = '';
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
