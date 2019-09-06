<?php

namespace App\Http\Controllers;

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
        $data = [
            'promo_description' => '',
            'amount' => 0,
            'merchant_id' => MerchantLocation::find($request->merchantlocation_id)->mall_id,
            'live' => 'Y',
            'featured' => 'N',
            'redeem' => 'N',
            'dated' => now()->format('d/m/y'),
            'user_id' => auth()->user()->user_id,
            'start_on' => '',
            'ends_on' => ''
        ];

        $promotion = PromotionOutlet::create($request->all() + $data);
        $promotion->load('merchant', 'merchantLocation');

        return response()->json($promotion);
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
        //
    }
}
