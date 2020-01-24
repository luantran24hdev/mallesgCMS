<?php

namespace App\Http\Controllers;

use App\PreferenceMaster;
use App\PromotionPreference;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PreferenceMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $preference_master = PreferenceMaster::all();
        $data = [
            'preference_tags' => $preference_master
        ];

        return view('main.preference_tag.preference_tags',$data);
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
            'preference_name.required'    => 'Time Preference field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'preference_name' => 'required|unique:preference_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $preference_master = new PreferenceMaster();
        $preference_master->preference_name = $request->preference_name;
        $preference_master->created_on = Carbon::now();
        $preference_master->created_by = \Auth::user()->user_id;
        $preference_master->image = '';
        $preference_master->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added preference'),
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
        $tagMaster = PreferenceMaster::find($id);

        $data = [
            'tagMaster' => $tagMaster,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.preference_tag.edit_tags',$data);
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
            'preference_name.required'    => 'Time Preference field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'preference_name' => 'required|unique:preference_master,preference_name,'.$id.',preference_id',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $tag_master = PreferenceMaster::find($id);
        $tag_master->preference_name = $request->preference_name;
        $tag_master->created_on = Carbon::now();
        $tag_master->created_by = \Auth::user()->user_id;
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
        $preference_master = PreferenceMaster::find($id);
        $preference_master->delete();

        return response()->json([
            'status' => $preference_master ? 'success' : 'error',
            'message' => $preference_master ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function promotionPreferenceStore(Request $request)
    {
        $messages = [
            'preference_id.required'    => 'Invalid Preference name!'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'promo_id' => 'required',
            'preference_id' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }



        $ifexist = PromotionPreference::where('promo_id',$request->promo_id)->where('preference_id',$request->preference_id)->first();

        if(!empty($ifexist)){

            return response()->json([
                'status' => 'error',
                'message' => __('Already Added.'),
            ],200);

        }
        else{

            $insert = new PromotionPreference;
            $insert->promo_id = $request->promo_id;
            $insert->preference_id = $request->preference_id;
            $insert->merchant_id = $request->merchant_id;
            $insert->dated = Carbon::now()->format('d/m/Y');
            $insert->user_id = \Auth::user()->user_id;
            $insert->save();


        }

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added Preference.'),
            //'tag_name' => $request->tag_name,
            //'id' => $insert->pt_id
        ],200);
    }

    public function promotionPreferenceDestroy($id)
    {
        $promotionPreference = PromotionPreference::find($id);
        $promotionPreference->delete();

        return response()->json([
            'status' => $promotionPreference ? 'success' : 'error',
            'message' => $promotionPreference ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function setPrimary($id)
    {
        $update = PromotionPreference::find($id);
        $update->primary_tag= request()->primary_tag;
        $update->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated'),
            //    'id' => $id
        ],200);
    }

    public function uploadimage(Request $request)
    {
        $file = $request->files->get('image');

        //return $file;
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->preference_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            $tag = PreferenceMaster::find($request->preference_id);
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

        $image = PreferenceMaster::find($id);

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

    public function search($name){
        return PreferenceMaster::search($name);
    }

}
