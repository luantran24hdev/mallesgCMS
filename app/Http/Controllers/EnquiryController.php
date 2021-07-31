<?php

namespace App\Http\Controllers;

use App\InquiryMaster;
use Illuminate\Http\Request;

class EnquiryController extends Controller
{
    public function getInquiry(){

        $inquiries = InquiryMaster::all();

        $data = [
            'inquiries' =>$inquiries
        ];

        return view('main.inquiry.index',$data);
    }
}
