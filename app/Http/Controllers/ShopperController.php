<?php

namespace App\Http\Controllers;

use App\CountryMaster;
use App\ShopperMaster;
use Illuminate\Http\Request;

class ShopperController extends Controller
{
    public function destroy($id)
    {
        $tagMaster = ShopperMaster::find($id);
        $tagMaster->delete();

        return response()->json([
            'status' => $tagMaster ? 'success' : 'error',
            'message' => $tagMaster ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function getShoppers(){

        $shoppers = ShopperMaster::all();

        $data = [
            'shoppers' => $shoppers,
            'live_url' => env('LIVE_URL').'images/shopper/'
        ];

        return view('main.shoppers.index',$data);
    }

    public function editShoppers($id){
        $shopper = ShopperMaster::find($id);
        $countrys =  CountryMaster::all();

        $data = [
            'shopper' => $shopper,
            'countrys' => $countrys,
            'live_url' => env('LIVE_URL').'images/shopper/'
        ];

        return view('main.shoppers.edit',$data);

    }

    public function updateShoppers($id, Request $request){

        $validator = \Validator::make($request->all(), [
            'Mobile_number' => 'required',
            'Email_id' => 'required',
        ]);



        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $shopper = ShopperMaster::find($id);
        $shopper->Shopper_name = $request->Shopper_name;
        $shopper->Gender = $request->Gender;
        $shopper->Email_id = $request->Email_id;
        $shopper->Mobile_number = $request->Mobile_number;
        //$shopper->Country_id = $request->country_id;
       // $shopper->E_VERIFIED = ($request->E_VERIFIED) ? $request->E_VERIFIED : NULL;
       // $shopper->M_VERIFIED = ($request->M_VERIFIED) ? $request->M_VERIFIED : NULL;
        $shopper->save();


        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated'),
        ],200);


    }

    public function uploadimage(Request $request)
    {
        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->Shopper_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/shopper/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $tag = ShopperMaster::find($request->Shopper_id);
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

        $image = ShopperMaster::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/images/shopper/'.$image->image);
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
