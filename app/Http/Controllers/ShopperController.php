<?php

namespace App\Http\Controllers;

use App\ShopperMaster;
use Illuminate\Http\Request;

class ShopperController extends Controller
{
    public function getShoppers(){

        $shoppers = ShopperMaster::all();

        $data = [
            'shoppers' => $shoppers
        ];

        return view('main.shoppers.index',$data);
    }
}
