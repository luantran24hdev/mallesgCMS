<?php

namespace App\Http\Controllers;

use App\ManageAge;
use App\PromotionAgeGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManageAgeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manageAge = ManageAge::all();
        $data = [
            'manageAges' => $manageAge,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.manage_age.index',$data);
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
            'age_group_name.required'    => 'Age Group Name field is required',
            'age_group.required'    => 'Age Group field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'age_group_name' => 'required',
            'age_group' => 'required',

        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $age = new ManageAge();
        $age->age_group_name = $request->age_group_name;
        $age->age_group = $request->age_group;
        $age->ag_image = NULL;
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
        $tagMaster = ManageAge::find($id);

        if(!empty($tagMaster->ag_image)){
            if(env('APP_ENV')=='live')
                unlink('../../admin/images/stock/'.$tagMaster->ag_image);
            else
                unlink('../storage/app/public/'.$tagMaster->ag_image);
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

            $newfilename = md5($request->age_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = ManageAge::find($request->age_id);
            $tag->ag_image = $newfilename;
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

        $image = ManageAge::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/stock/'.$image->ag_image);
        else
            unlink('../storage/app/public/'.$image->ag_image);

        $image->ag_image = '';
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function promotionAgeStore(Request $request)
    {
        $messages = [
            'ag_id.required'    => 'Invalid Age Group name!'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'promo_id' => 'required',
            'ag_id' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }



        $ifexist = PromotionAgeGroup::where('promo_id',$request->promo_id)->where('ag_id',$request->ag_id)->first();

        if(!empty($ifexist)){

            return response()->json([
                'status' => 'error',
                'message' => __('Already Added.'),
            ],200);

        }
        else{

            $insert = new PromotionAgeGroup;
            $insert->promo_id = $request->promo_id;
            $insert->ag_id = $request->ag_id;
            $insert->primary_cat = 'N';
            $insert->merchant_id = $request->merchant_id;
            $insert->created_on = Carbon::now()->format('d/m/Y');
            $insert->created_by = \Auth::user()->user_id;
            $insert->save();


        }

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added!.'),
            //'tag_name' => $request->tag_name,
            //'id' => $insert->pt_id
        ],200);
    }

    public function promotionAgeDestroy($id)
    {
        $promotionPreference = PromotionAgeGroup::find($id);
        $promotionPreference->delete();

        return response()->json([
            'status' => $promotionPreference ? 'success' : 'error',
            'message' => $promotionPreference ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function setPrimary($id)
    {
        $update = PromotionAgeGroup::find($id);
        $update->primary_cat= request()->primary_tag;
        $update->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated'),
            //    'id' => $id
        ],200);
    }

}
