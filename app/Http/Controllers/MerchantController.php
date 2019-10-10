<?php

namespace App\Http\Controllers;

use App\CountryMaster;
use App\MallType;
use App\MerchantImage;
use App\MerchantMaster;
use App\MerchantType;
use App\PromotionOutlet;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Repositories\MerchantRepository; 
use App\Repositories\MallRepository; 

use App\LevelMaster;


class MerchantController extends Controller
{

    /**
    * @var MerchantRepository
    *
    */
    protected $merchant;

    /**
    * @var MallRepository
    *
    */
    protected $mall;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MerchantRepository $merchant, MallRepository $mall)
    {
        $this->merchant =  $merchant; 
        $this->mall =  $mall; 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $merchants = $this->merchant->all()->pluck('merchant_name', 'merchant_id');

        $data = [
           'merchantOptions' => $merchants->toJson()
        ];

         return view('main.merchants.index',$data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $merchantOptions = $this->merchant->all()->pluck('merchant_name', 'merchant_id')->toJson() ?? [];
        $mallOptions = $this->mall->all()->pluck('mall_name', 'mall_id')->toJson() ?? [];
        $current_merchant = $this->merchant->find($id) ?? [];
        $locations = $current_merchant->loc($id);
        $floors = LevelMaster::all();

        //return $locations;
        $data = [
            'merchantOptions' => $merchantOptions,
            'current_merchant' => $current_merchant,
            'locations' => $locations,
            'mallOptions' => $mallOptions,
            'floors' => $floors,
            'id' => $id
        ];


        //return $current_merchant;

        return view('main.merchants.index',$data);
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
        //$delete = $this->merchant->delete($id);


        $delete = $this->merchant->destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);

    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return $this->merchant->search($name);
    }

    public function merchantList(Request $request)
    {
        $merchants = $this->merchant->all()->pluck('merchant_name', 'merchant_id');
        $count_merchant = MerchantMaster::count();
        $current_merchants = MerchantMaster::orderBy('merchant_id','desc')->get();
        $countrys = CountryMaster::all();
        $merchant_types = MerchantType::all();
        //return $count_all_me_type;
        $data = [
            'merchantOptions' => $merchants->toJson(),
            'total_merchant' => $count_merchant,
            'countrys' => $countrys,
            'current_merchants' => $current_merchants,
            'merchant_types' => $merchant_types,
        ];

        return view('main.merchants_list.index',$data);
    }

    public function merchantListShow($id)
    {
        $merchantOptions = $this->merchant->all()->pluck('merchant_name', 'merchant_id')->toJson() ?? [];
        $current_merchants = MerchantMaster::where('merchant_id',$id)->get() ?? [];
        $count_merchant = MerchantMaster::where('merchant_active','Y')->count();
       // $outlate_totel = PromotionOutlet::where('merchant_id',$id)->count();
        $countrys = CountryMaster::all();
//return $current_merchant;
        $data = [
            'merchantOptions' => $merchantOptions,
            'current_merchants' => $current_merchants,
           //'outlate_totel' => $outlate_totel,
            'total_merchant' => $count_merchant,
            'countrys' => $countrys,
            'id' => $id
        ];

        return view('main.merchants_list.index',$data);
    }

    public function columnUpdate($id){

        $this->merchant->update($id, [
            request()->name => request()->value
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated merchant'),
            'id' => $id
        ],200);
    }


    public function merchantImages($id)
    {

        $merchant = MerchantMaster::find($id);

        //return $mall->mallImage;
        $data = [
            'merchant' => $merchant,
            'live_url' => env('LIVE_URL').'main_merchant/'
        ];

        return view('main.merchants_list.merchant_images',$data);
    }


    public function uploadimage(Request $request)
    {

        $file = $request->files->get('image');
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->mall_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/main_merchant/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);

            if(isset($request->image_count)){

                $merchant = new MerchantImage();
                $merchant->merchant_id = $request->merchant_id;
                $merchant->image_name = $newfilename;
                $merchant->image_count = $request->image_count;
                $merchant->date_added = Carbon::now()->format('Y-m-d');
                $merchant->save();

            }else{
                $merchant = MerchantMaster::find($request->merchant_id);
                $merchant->web_image = $newfilename;
                $merchant->save();
            }

        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }

        return response()->json([
            'status' => 'success' ,
            'message' =>__('succesfully uploaded'),
            'file' => env("LIVE_URL").$newfilename
        ],200);

    }


    public function webdeleteimage($id)
    {

        $image = MerchantMaster::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/main_merchant/'.$image->web_image);
        else
            unlink('../storage/app/public/'.$image->web_image);


        $image->web_image = Null;
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function deletemallimage($id){

        $image = MerchantImage::find($id);

        if(env('APP_ENV')=='live')
            unlink('../../admin/main_merchant/'.$image->image_name);
        else
            unlink('../storage/app/public/'.$image->image_name);

        $delete = MerchantImage::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->image_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }
}
