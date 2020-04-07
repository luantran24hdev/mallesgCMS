<?php

namespace App\Http\Controllers;

use App\CityMaster;
use App\CompanyMaster;
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
//        /return "ddddtt";
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
        $messages = [
            'merchant_name.required'    => 'Merchant name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'merchant_name' => 'required|unique:merchant_master',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $merchant = new MerchantMaster();
        $merchant->merchant_name = $request->merchant_name;
        $merchant->city_id = 0;
        $merchant->country_id = ($request->country_id) ? $request->country_id : 1;
        $merchant->town_id = 0;
        $merchant->company_id = 0;
        $merchant->mt_id = ($request->mt_id) ? $request->mt_id : 0;
        $merchant->featured = 'N';
        $merchant->youtube = '';
        $merchant->merchant_active = 'N';
        $merchant->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added merchant'),
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
        $merchant = MerchantMaster::find($id);
        $merchantTypes = MerchantType::all();
        $countrys = CountryMaster::all();
        $citys = CityMaster::all();
        $companys = CompanyMaster::all();

        $data = [
            'merchant' => $merchant,
            'countries' => $countrys,
            'merchantTypes' => $merchantTypes,
            'companys' => $companys,
            'cities' => $citys
        ];
        return view('main.merchants_list.merchant_info',$data);
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
        //return $request->all();
        $messages = [
            'merchant_name.required'    => 'Merchant name field is required'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'merchant_name' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }

        $merchant = MerchantMaster::find($id);
        $merchant->merchant_name = $request->merchant_name ?  $request->merchant_name : '';
        $merchant->short_name = $request->short_name ?  $request->short_name : '';
        $merchant->mt_id = $request->mt_id ? $request->mt_id : '';
        $merchant->merchant_address = $request->merchant_address ? $request->merchant_address : '';
        $merchant->country_id = $request->country_id ? $request->country_id : 1;
        $merchant->city_id = $request->city_id ? $request->city_id : 1;
        $merchant->postal_code = $request->postal_code ? $request->postal_code : '';
        $merchant->telephone = $request->telephone ? $request->telephone : '';
        $merchant->website = $request->website ? $request->website : '';
        $merchant->facebook = $request->facebook ? $request->facebook : '';
        $merchant->instagram = $request->instagram ? $request->instagram : '';
        $merchant->twitter = $request->twitter ? $request->twitter : '';
        $merchant->youtube = $request->youtube ? $request->youtube : '';
        $merchant->opening_hour = $request->opening_hour ? $request->opening_hour : '';
        $merchant->company_id = $request->company_id ? $request->company_id : 0;
        $merchant->about_us = $request->about_us ? $request->about_us : '';
        $merchant->delivery_charge = $request->delivery_charge ? $request->delivery_charge : null;
        $merchant->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated merchant'),
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

        $name = request()->name;
        $merchant = MerchantMaster::find($id);
        $merchant->$name = request()->value;
        $merchant->save();
       /* $this->merchant->update($id, [
            request()->name => request()->value
        ]);*/

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated '. request()->name),
            'id' => $id
        ],200);
    }


    public function merchantImages($id)
    {

        //return "hello".env('APP_URL');

        $merchant = MerchantMaster::find($id);

        //return $mall->mallImage;
        $data = [
            'merchant' => $merchant,
            'live_url' => env('LIVE_URL').'images/merchant_images/',
            'logo_live_url' => env('LIVE_URL').'images/merchant_logo/'
        ];

        //return $data;

        return view('main.merchants_list.merchant_images',$data);
    }


    public function uploadimage(Request $request)
    {

        $file = $request->files->get('file');
        try {

            if($file->getMimeType()!="image/png" && $file->getMimeType()!="image/jpeg" && $file->getMimeType()!="image/jpg"){
                throw new \Exception("invalid file", 500);
            }

            $newfilename = md5($request->merchant_id . "_" . round(microtime(true))) . '.png';

            if(isset($request->image_count)){

                if($request->image_count == 0){
                    $file->move('../../admin/images/merchant_logo/', $newfilename);
                    $merchant = MerchantMaster::find($request->merchant_id);
                    $merchant->merchant_logo = $newfilename;
                    $merchant->save();
                }else{
                    $file->move('../../admin/images/merchant_images/', $newfilename);
                    $merchant = new MerchantImage();
                    $merchant->merchant_id = $request->merchant_id;
                    $merchant->image_name = $newfilename;
                    $merchant->image_count = $request->image_count;
                    $merchant->date_added = Carbon::now()->format('Y-m-d');
                    $merchant->save();
                }

            }else{
                $file->move('../../admin/images/merchant_images/', $newfilename);
                $merchant = MerchantMaster::find($request->merchant_id);
                $merchant->web_image = $newfilename;
                $merchant->save();
            }

        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }


        return response()->json(['success' ,'succesfully uploaded']);

        /*return response()->json([
            'status' => 'success' ,
            'image_count' => @$request->image_count,
            'message' =>__('succesfully uploaded'),
            'file' => env("LIVE_URL").$newfilename
        ],200);*/

    }


    public function webdeleteimage($id)
    {

        $image = MerchantMaster::find($id);

        unlink('../../admin/images/merchant_images/' . $image->web_image);

        $image->web_image = Null;
        $image->save();

        return response()->json([
            'status' => $image ? 'success' : 'error',
            'message' => $image ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function deletemallimage($id){

        $image = MerchantImage::find($id);
        unlink('../../admin/images/merchant_images/' . $image->image_name);

        $delete = MerchantImage::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'image_count' => @$image->image_count,
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function deletelogoimage($id){

        $image1 = MerchantMaster::find($id);
        unlink('../../admin/images/merchant_logo/' . $image1->merchant_logo);
        $image1->merchant_logo = Null;
        $image1->save();
        return response()->json([
            'status' => $image1 ? 'success' : 'error',
            'message' => $image1 ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


}
