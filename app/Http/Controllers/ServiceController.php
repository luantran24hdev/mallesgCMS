<?php

namespace App\Http\Controllers;

use App\ServiceMaster;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = ServiceMaster::all();
        $data = [
            'services' => $services,
            'live_url' => env('LIVE_URL').'images/stock/'
        ];

        return view('main.parking.edit', $data);
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $messages = [
            'service_name.required'    => 'Service name is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'service_name' => 'required|unique:service_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        ServiceMaster::updateOrcreate([
            'service_name' => $request->service_name,
            'mall_id' => $request->mall_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tags'),
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



    public function edit($id)
    {
        $service = ServiceMaster::where('service_id', $id)->first();

        return view('main.parking.edit_service', [
            'service' => $service,
            'live_url' => env('LIVE_URL').'images/stock/'
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        //return $request->all();
        error_log($request);
        $messages = [
            'service_name.required'    => 'Service name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'service_name' => 'required|unique:service_master,service_name,'.$id.',service_id',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $service = ServiceMaster::where('service_id',$id)->first();
        $service->service_name = $request->service_name;
        $service->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully Updated tags'),
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
        $service = ServiceMaster::where('service_id', $id)->first();

        if(!empty($service->image)){
            if(env('APP_ENV')=='live')
                unlink('../../admin/images/stock/'.$service->image);
            else
                unlink('../storage/app/public/'.$service->image);
        }

        $service->delete();

        return response()->json([
            'status' => $service ? 'success' : 'error',
            'message' => $service ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function search($name){
        return ServiceMaster::search($name);
    }


    public function uploadimage(Request $request)
    {
        $file = $request->files->get('file');
        try{

            if($file->getMimeType()!="image/png" && $file->getMimeType()!="image/jpeg" && $file->getMimeType()!="image/jpg"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->tag_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/images/stock/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);


            $service = ServiceMaster::where('service_id', $request->service_id)->first();
            $service->service_image = $newfilename;
            $service->save();


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
