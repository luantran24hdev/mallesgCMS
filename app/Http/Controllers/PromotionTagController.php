<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\PromotionTagRepository; 
use App\Tagmaster;
use Carbon\Carbon;
use Auth;


class PromotionTagController extends Controller
{

    /**
    * @var TagRepository
    *
    */
    protected $tag;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromotionTagRepository $tag)
    {
        $this->tag =  $tag; 
    }

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
            'tag_id.required'    => 'Invalid tag name!'
        ];
 
        // Start Validation
        $validator = Validator::make($request->all(), [
            'promo_id' => 'required',
            'merchant_id' => 'required',
            'tag_id' => 'required',
        ],$messages);
        
        if($validator->fails()){ 
           return response()->json([
                'status' => 'error',
                'message' => $validator->messages()->first()
           ],200);
        }

        $insert = $this->tag->create([  
            'promo_id' => $request->promo_id,
            'tag_id' => $request->tag_id,
            'merchant_id' => $request->merchant_id,
            'primary_tag' => "",
            'dated' => Carbon::now()->format('d/m/Y'),
            'user_id' =>  Auth::user()->user_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => __('successfully added tag'),
            'tag_name' => $request->tag_name,
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
        $delete = $this->tag->destroy($id);
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
        return $this->tag->search($name);
    }

    /**
     * 
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function setPrimary($id)
    {
 
        $this->tag->update($id, [
            'primary_tag' => request()->primary_tag
        ]);

         return response()->json([
            'status' => 'success',
            'message' => __('successfully updated tag'),
            'id' => $id
        ],200);
    }
}
