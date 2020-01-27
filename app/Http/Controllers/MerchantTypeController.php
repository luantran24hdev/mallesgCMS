<?php

namespace App\Http\Controllers;

use App\MerchantMaster;
use App\MerchantType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MerchantTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $merchant_types = MerchantType::all();
        $merchants = MerchantMaster::count();

        $data = [
            'merchant_types' => $merchant_types,
            'merchants' => $merchants,
        ];

        return view('main.merchants_list.merchanttype',$data);
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
            'type.required'    => 'Merchant Type name field is required',
            'type.unique'    => 'Merchant Type name already has been taken'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'type' => 'required|unique:merchant_type',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $merchant = new MerchantType();
        $merchant->type = $request->type;
        $merchant->dated = Carbon::now()->format('d/m/Y');
        $merchant->user_id = Auth::user()->user_id;
        $merchant->image = NULL;
        $merchant->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tag'),
            'id' => $merchant->mt_id
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
        $merchanttype = MerchantType::find($id);

        $data = [
            'merchanttype' => $merchanttype,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.merchants_list.edit_merchanttype',$data);
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
            'type.required'    => 'Type name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'type' => 'required|unique:merchant_type,type,'.$id.',mt_id',
        ],$messages);



        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $merchanttype = MerchantType::find($id);
        $merchanttype->type = $request->type;
        $merchanttype->dated = Carbon::now()->format('d/m/Y');
        $merchanttype->user_id = Auth::user()->user_id;
        $merchanttype->save();

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
        $mercahnttype = MerchantType::find($id);
        if(!empty($mercahnttype->image)){
            unlink('../../admin/images/stock/'.$mercahnttype->image);
        }
        $mercahnttype->delete();

        return response()->json([
            'status' => $mercahnttype ? 'success' : 'error',
            'message' => $mercahnttype ? __('succesfully deleted') : __('error deleting')
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


            $tag = MerchantType::find($request->mt_id);
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

        $image = MerchantType::find($id);

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
