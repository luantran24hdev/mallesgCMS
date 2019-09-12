<?php

namespace App\Http\Controllers;

use App\MallMaster;
use App\MerchantLocation;
use App\PromotionMaster;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Request as sRequest;
use Illuminate\Support\Facades\Validator;

use App\Repositories\PromotionRepository; 
use App\Repositories\MerchantRepository; 
use App\MerchantPromoImage;

use Carbon\Carbon;
use Auth;

class PromotionController extends Controller
{

    /**
    * @var MallRepository
    *
    */
    protected $promotion;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MerchantRepository $merchant, PromotionRepository $promotion)
    {
        $this->promotion =  $promotion;  
        $this->merchant =  $merchant; 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotion = $this->promotion->all()->pluck('promo_name', 'promo_id');

        $data = [
           'promoOptions' => $promotion->toJson()
        ];

        return view('main.promotions.index',$data);
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
            
        ];
 
        // Start Validation
        $validator = Validator::make($request->all(), [
            'promo_name' => 'required',
            'merchant_id' => 'required',
        ],$messages);
        
        if($validator->fails()){ 
           return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
           ],200);
        }

        $insert = $this->promotion->create([ 
            'user_id' => Auth::user()->user_id,
            'promo_name' => $request->promo_name,
            'merchant_id' => $request->merchant_id,
            'description' => "",
            'dated' => "",
            'start_on' => "",
            'ends_on' => "",
            'no_end_date' => "",
            'active' => "N",
            'promo_active' => "N",
            'dm_id' => 0,
            'redeemable' => "N",
        ]);

        return response()->json([
            'status' => 'success',
            'promo_name' => $request->promo_name,
            'id' => $insert->id
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
        $current_merchant = $this->merchant->find($id) ?? [];
        $promotions = $current_merchant->promotions;
        $current_promo = $this->promotion->find(request()->promo_id) ?? [];
        $daysofweek = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $mall_id_lists = MerchantLocation::with('mall')->where('merchant_id', $id)->distinct()->pluck('mall_id');

        $mall_list = [];
        if (!empty($mall_id_lists)) {
            foreach ($mall_id_lists as $key => $list) {
                $mall_name = MallMaster::find($list);
                $mall_list[$key]['mall_id'] = $list;
                $mall_list[$key]['mall_name'] = $mall_name['mall_name'];
            }
        }

        $data = [
            'merchantOptions' => $merchantOptions,
            'current_merchant' => $current_merchant, 
            'promotions' => $promotions,
            'id' => $id,
            'promo_id' => request()->promo_id ?? null,
            'current_promo' => $current_promo,
            'daysofweek' => $daysofweek,
            'promotion_days' => $current_promo->promotion_days ?? [],
            'promotion_images' => $current_promo->images ?? [],
            'promotion_tags' => $current_promo->promotion_tags ?? [],
            'live_url' => env('LIVE_URL'),
            'mall_lists' => $mall_list
        ];

        //return $current_promo->outlets;
        //return $data;
        return view('main.promotions.index',$data);
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
    public function update($id)
    {
       // try {
            $request = request();
            $messages = [
                 
            ];

            // Start Validation
            $validator = Validator::make($request->all(), [
                'promo_id' => 'required',
                'merchant_id' => 'required',
                'promo_name' => 'required',
                'description' => 'required',
                'amount' => 'required',
                'start_on' => 'required',
                'ends_on' => $request->no_end_date ? '': 'required'
            ],$messages);
            
            if($validator->fails()){ 
               return response()->json([
                    'status' => 'error',
                    'message' => $validator->messages()->first()
               ],200);
            }

            $update = $this->promotion->update( $request->promo_id,[
                'merchant_id' => $request->merchant_id,
                'promo_name' => $request->promo_name,
                'description' => $request->description,
                'amount' => $request->amount,
                'start_on' => $request->start_on,
                'ends_on' => $request->no_end_date ? "": $request->ends_on,
                'other_offer' => $request->other_offer ?? null, 
                'no_end_date' => $request->no_end_date ?? "",
                'active' => $request->active_txt ?? "",
                'promo_active' => $request->active_txt ?? "",
                'redeemable' => $request->redeemable_txt ?? null,
            ]);

            return response()->json([
                'status' => 'success',
                'message' => __('succesfully updated!'),
                'promo_name' => $request->promo_name,
                'id' => $request->promo_id
            ],200);
        // } catch (QueryException $e) {
        //     throw new \InvalidArgumentException('Erro inserting', 500, $e);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->promotion->destroy($id);
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
    public function uploadimage(sRequest $request)
    {
 
        $file = $request->files->get('image');
 
        try{

            if($file->getMimeType()!="image/png"){
                throw new \Exception("invalid file", 500);
            }


            $newfilename = md5($request->promo_id."_".$request->merchant_id."_".round(microtime(true))) . '.png';

            if(env('APP_ENV')=='live')
                $file->move('../../admin/promos/', $newfilename);
            else
                $file->move('../storage/app/public/', $newfilename);
            
            MerchantPromoImage::create([
                'promo_id' => $request->promo_id,
                'merchant_id' => $request->merchant_id,
                'image_name' => $newfilename,
                'image_count' => $request->image_count,
                'date_added' => Carbon::now()
            ]);

        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }

        return response()->json([
            'status' => 'success' ,
            'message' =>__('succesfully uploaded'),
            'file' => env("LIVE_URL").$newfilename
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteimage($id)
    {
        
        $image = MerchantPromoImage::find($id);

        if(env('APP_ENV')=='live')
                unlink('../../admin/promos/'.$image->image_name);
            else
                unlink('../storage/app/public/'.$image->image_name);

        $delete = MerchantPromoImage::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }


    public function getLocation(Request $request){
        //return $request->mall_id;
        if($request->ajax()){
          if($request->mall_id != NULL && $request->merchent_id != NULL){
              $mall_id = $request->mall_id;
              $merchent_id = $request->merchent_id;

              $locations = MerchantLocation::where('merchant_id',$merchent_id)->where('mall_id',$mall_id)->get();
              $loc = "";
              if(count($locations) > 0){

                  if(count($locations) > 1){
                    $loc.="<option value=''>--- Select ----</option>";
                  }
                foreach ($locations as $location){
                    $loc.='<option value="'.$location->merchantlocation_id.'">'.$location->merchant_location.'</option>';
                }

              return response()->json([
                  'status' => 'success' ,
                  'message' =>__('succesfully uploaded'),
                  'location' => $loc
              ],200);

              }else{

                  $loc.="<option value=''>--- Select ----</option>";
                  $loc.="<option value=''>NO Data Found</option>";

                  return response()->json([
                      'status' => 'success' ,
                      'message' =>__('succesfully uploaded'),
                      'location' => $loc
                  ],200);
              }
          }else{
              return response()->json([
                  'location' => "No Data Found"
              ],200);

          }
        }

        return response()->json([
            'location' => "No Data Found"
        ],200);
    }

    public function activeUp(Request $request)
    {

        $name = request()->name;
        $id = $request->promo_id;
        $promo_master = PromotionMaster::find($id);
        $promo_master->$name = request()->value;
        $promo_master->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated !'),
            'id' => $id
        ],200);
    }
 

}
