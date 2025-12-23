<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProfileRequest;

class MypageController extends Controller
{
    // プロフィール表示
    public function mypage()
    {
        return view('mypage.index');
    }

    // プロフィール編集画面表示
    public function editprofile(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;

        $from = $request->query('from');

        return view('mypage.edit', compact('profile', 'from'));
    }

    // プロフィール更新処理
    public function updateprofile(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_name' => $request->user_name,
                'post_num' => $request->post_num,
                'address' => $request->address,
                'building' => $request->building,
            ]
        );

        if ($request->from === 'register') {
            return redirect('/?tab=mylist');
        }

        return redirect()->route('mypage.index');
    }

    // 購入履歴/出品一覧表示
    public function index()
    {
        
    }
}
