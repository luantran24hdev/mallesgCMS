<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PromotionDayRepository; 
use App\PromotionDay;

class PromotionDayController extends Controller
{
    /**
    * @var TagRepository
    *
    */
    protected $day;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PromotionDayRepository $day)
    {
        $this->day =  $day; 
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
    public function update($id)
    {
        $this->day->update($id, [
             request()->day => request()->value
        ]);

         return response()->json([
            'status' => 'success',
            'message' => __('successfully updated day!'),
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
        //
    }
}
