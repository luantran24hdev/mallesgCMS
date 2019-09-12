<?php

namespace App\Http\Controllers;

use App\PromotionCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PromotionCategoryController extends Controller
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
        $messages = [
            'sub_category_id.required'    => 'Invalid Category name!'
        ];

        // Start Validation
        $validator = \Validator::make($request->all(), [
            'promo_id' => 'required',
            'merchant_id' => 'required',
            'sub_category_id' => 'required',
        ],$messages);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
            ],200);
        }



        $ifexist = PromotionCategory::where('promo_id',$request->promo_id)->where('sub_category_id',$request->sub_category_id)->first();

        if(!empty($ifexist)){

            return response()->json([
                'status' => 'error',
                'message' => __('Already Added.'),
            ],200);

        }
        else{
            //return "Hellooo";
           /* $insert = $this->tag->create([
                'promo_id' => $request->promo_id,
                'tag_id' => $request->tag_id,
                'merchant_id' => $request->merchant_id,
                'primary_tag' => "",
                'dated' => Carbon::now()->format('d/m/Y'),
                'user_id' =>  Auth::user()->user_id,
            ]);*/


            $insert = new PromotionCategory;
            $insert->promo_id = $request->promo_id;
            $insert->sub_category_id = $request->sub_category_id;
            $insert->merchant_id = $request->merchant_id;
            $insert->dated = Carbon::now()->format('d/m/Y');
            $insert->user_id = \Auth::user()->user_id;
            $insert->save();


        }

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added Category.'),
            //'tag_name' => $request->tag_name,
            //'id' => $insert->pt_id
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
        $delete = PromotionCategory::find($id);
        $delete = $delete->delete();
        return response()->json([
            'status' => $delete ? 'success' : 'error',
            'message' => $delete ? __('succesfully deleted') : __('error deleting')
        ],200);
    }

    public function setPrimary($id)
    {
        $update = PromotionCategory::find($id);
        $update->primary_cat= request()->primary_tag;
        $update->save();

        return response()->json([
            'status' => 'success',
            'message' => __('successfully updated tag'),
        //    'id' => $id
        ],200);
    }
}
