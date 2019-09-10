<?php

namespace App\Http\Controllers;

use App\PromotionOutletsDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PromotionOutletsDaysController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $ifexists = PromotionOutletsDay::where('po_id',$request->po_id)->first();

        $daysofweeks = ['monday','tuesday','wednesday','thursday','friday','saturday','sunday'];

        if(!empty($ifexists)){

            foreach ($daysofweeks as $days){
                $out_day = PromotionOutletsDay::find($ifexists->pod_id);
                if($days == $request->day){
                    $out_day->$days = $request->value;
                }else{
                    $out_day->$days = 'N';
                }
                $out_day->save();
            }
            $msg = "Updated";

        }else{
            $out_day = new PromotionOutletsDay;
            $out_day->po_id = $request->po_id;
            $out_day->promo_id = $request->promo_id;
            foreach ($daysofweeks as $days){
                if($days == $request->day){
                    $out_day->$days = $request->value;
                }else{
                    $out_day->$days = 'N';
                }

            }
            $out_day->save();
            $msg = "Added";
        }
        return response()->json([
            'status' => 'success',
            'message' => __('successfully '.$msg.' day!'),
            //'id' => $id
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
        //
    }
}
