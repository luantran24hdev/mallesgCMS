<?php

namespace App\Http\Controllers;

use App\Mealgroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MealgroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mealgroups = Mealgroup::all();
        $data = [
            'mealgroups' => $mealgroups,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.meal_group.index',$data);
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
            'meal_name.required'    => 'Meal Name field is required',
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'meal_name' => 'required',

        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $age = new Mealgroup();
        $age->meal_name = $request->meal_name;
        $age->meal_image = NULL;
        $age->created_on = Carbon::now()->format('d/m/Y');
        $age->created_by = \Auth::user()->user_id;
        $age->save();

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
        $tagMaster = Mealgroup::find($id);

        if(!empty($tagMaster->meal_image)){
            if(env('APP_ENV')=='live')
                unlink('../../admin/images/stock/'.$tagMaster->meal_image);
            else
                unlink('../storage/app/public/'.$tagMaster->meal_image);
        }
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function uploadimage(Request $request)
    {
        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }

            $newfilename = md5($request->mg_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = Mealgroup::find($request->mg_id);
            $tag->meal_image = $newfilename;
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

        $image = Mealgroup::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/stock/'.$image->meal_image);
        else
            unlink('../storage/app/public/'.$image->meal_image);

        $image->meal_image = '';
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

}
