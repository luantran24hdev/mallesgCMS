<?php

namespace App\Http\Controllers;

use App\MallMaster;
use App\MallType;
use Illuminate\Http\Request;

class MallTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mall_types = MallType::all();
        $malls = MallMaster::count();

        $data = [
            'mall_types' => $mall_types,
            'malls' => $malls,
        ];

        return view('main.mall_list.malltype',$data);
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
            'type_name.required'    => 'Type name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'type_name' => 'required|unique:mall_type',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $malltype = new MallType();
        $malltype->type_name = $request->type_name;
        $malltype->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tag'),
            'id' => $malltype->mt_id
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
        $malltype = MallType::find($id);

        $data = [
            'malltype' => $malltype,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.mall_list.edit_malltype',$data);
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
            'type_name.required'    => 'Type name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'type_name' => 'required|unique:mall_type,type_name,'.$id.',mt_id',
        ],$messages);



        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $malltype = MallType::find($id);
        $malltype->type_name = $request->type_name;
        $malltype->save();

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
        $malltype = MallType::find($id);

        if(!empty($malltype->image)){
            unlink('../../admin/images/stock/'.$malltype->image);
        }

        $malltype->delete();

        return response()->json([
            'status' => $malltype ? 'success' : 'error',
            'message' => $malltype ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function uploadimage(Request $request)
    {
        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->mt_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = MallType::find($request->mt_id);
            $tag->image = $newfilename;
            $tag->save();


        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }

        return response()->json([
            'status' => 'success' ,
            'message' =>__('succesfully uploaded')
        ],200);

    }

    public function deleteimage($id){

        $image = MallType::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/stock/'.$image->image);
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
