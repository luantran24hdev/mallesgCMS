<?php

namespace App\Http\Controllers;

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
        $locations = $current_merchant->locations;
        $floors = LevelMaster::all();
 
        $data = [
            'merchantOptions' => $merchantOptions,
            'current_merchant' => $current_merchant,
            'locations' => $locations,
            'mallOptions' => $mallOptions,
            'floors' => $floors,
            'id' => $id
        ];

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
        //
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

}
