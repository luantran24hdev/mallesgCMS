<?php

namespace App\Http\Controllers;

use App\InquiryMaster;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function getInquiry(){

        $inquiry = InquiryMaster::all();

        $data = [
            'inquirys' =>$inquiry
        ];

        return view('main.inquiry.index',$data);
    }
}
