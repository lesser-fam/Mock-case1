<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function editprofile()
    {
        return view('mypage.edit');
    }
}
