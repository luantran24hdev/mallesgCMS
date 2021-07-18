<?php

namespace App\Http\Controllers;

use App\ServiceMaster;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function index()
    {
        $services = ServiceMaster::all();
        $data = [
            'services' => $services,
            'image_url' => env('LIVE_URL').'images/'
        ];

        return view('main.services.index', $data);
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
            'service_name' => 'required:service_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        ServiceMaster::updateOrcreate([
            'service_name' => $request->service_name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added service'),
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

        return view('main.services.edit ', [
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
        $messages = [
            'service_name.required'    => 'Service name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'service_name' => 'required:service_master',
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
            'message' => __('successfully Updated Service'),
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
            if(env('APP_ENV')=='live') {
                $file_name = '../../admin/images/stock/' . $service->image;
            }
            else {
                $file_name = '../storage/app/public/' . $service->image;
            }

            Storage::delete($file_name);
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

    public function deleteimage($id)
    {

        $service = ServiceMaster::where('service_id', $id)->first();

        if(env('APP_ENV')=='live') {
            $file_name = '../../admin/images/stock/' . $service->service_image;
        }
        else {
            $file_name = '../storage/app/public/' . $service->service_image;
        }

        Storage::delete($file_name);

        $service->service_image = '';
        $service->save();

        return response()->json([
            'status' => $service ? 'success' : 'error',
            'message' => $service ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
