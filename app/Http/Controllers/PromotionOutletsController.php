<?php

namespace App\Http\Controllers;

use App\MerchantMaster;
use App\PromotionMaster;
use Illuminate\Http\Request;
use App\PromotionOutlet;
use App\MerchantLocation;

class PromotionOutletsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(empty($request->merchantlocation_id)){
            return response()->json([
                'status' => 'error',
                'message' => __('Location Field id required.'),
            ],200);
        }
        $data = [
            'promo_description' => '',
            'amount' => 0,
            'merchant_id' => MerchantLocation::find($request->merchantlocation_id)->mall_id,
            'live' => 'N',
            'featured' => 'N',
            'redeem' => 'N',
            'dated' => now()->format('d/m/y'),
            'user_id' => auth()->user()->user_id,
            'start_on' => '',
            'ends_on' => ''
        ];

       // return response()->json($data);
        //return $request->all();
        if(empty($request->merchantlocation_id)){
            return response()->json([
                'status' => 'error',
                'message' => __('Location Field id required.'),
            ],200);
        }
        $ifexists = PromotionOutlet::where('promo_id',$request->promo_id)->where('merchantlocation_id',$request->merchantlocation_id)->where('mall_id',$request->mall_id)->where('merchant_id',$request->merchant_id)->get();

        if(count($ifexists) > 0){
            return response()->json([
                'status' => 'error',
                'message' => __('Already added !'),
            ],200);
        }
        $promotion = PromotionOutlet::create($request->all() + $data);
        $promotion->load('merchant', 'merchantLocation', 'mall', 'merchantLocation.floor');

        //return response()->json($promotion);

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added !'),
            'promotion' => $promotion
        ],200);
    }

    public function show($id){

        $merchantOptions = MerchantMaster::all()->pluck('merchant_name', 'merchant_id')->toJson() ?? [];
        $current_merchant = MerchantMaster::find($id);
        $promotions = $current_merchant->promotions;

        $current_promo = PromotionMaster::find(request()->promo_id) ?? [];
        $daysofweek = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];
        $outlate_data = PromotionOutlet::find(request()->outlate_id) ?? [];
//return $current_promo;
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
            'outlate_data' => $outlate_data
        ];
        //return request()->promo_id;
        //return $current_promo;
        //return $outlate_data;
        //return $daysofweek[0];

        #dd($data);
        return view('main.promotions.editoutlets',$data);


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
        $name = request()->name;
        $promo_outlet = PromotionOutlet::find($id);
        $promo_outlet->$name = request()->value;
        $promo_outlet->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated !'),
            'id' => $id
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
        $delete = PromotionOutlet::destroy($id);
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function updateOutlate(Request $request){


        $validator = \Validator::make($request->all(), [
            'amount' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }


        $outlate = PromotionOutlet::find($request->out_id);
        $outlate->live = $request->live;
        $outlate->featured = $request->featured;
        $outlate->amount = $request->amount;
        $outlate->desc_2 = $request->desc_2 ? $request->desc_2 : '';
        $outlate->taxes = $request->taxes ? $request->taxes : 'N';
        $outlate->takeout = $request->takeout ? $request->takeout : 'N';
        $outlate->start_on = $request->start_on;
        $outlate->ends_on = $request->ends_on ? $request->ends_on : '';
        $outlate->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated !'),
        ],200);

    }
}
