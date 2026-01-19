<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Profile;
use App\Http\Requests\ProfileRequest;

class MypageController extends Controller
{
    // プロフィール表示/購入履歴/出品一覧表示
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $profile = $user->profile;

        $page = $request->query('page', 'sell');

        if ($page === 'buy') {
            $items = Item::whereHas('purchase', function ($q) use ($user) {
                $q->where('buyer_id', $user->id)
                  ->where('status', 'paid');
            })->get();
        } else {
            $items = Item::where('seller_id', $user->id)->get();
        }

        return view('mypage.index', compact('profile', 'items', 'page'));
    }

    // プロフィール編集画面表示
    public function editprofile(Request $request)
    {
        $user = Auth::user();

        $profile = $user->profile ?? $user->profile()->create([
            'user_name' => '',
        ]);

        return view('mypage.edit', compact('profile'));
    }

    // プロフィール更新処理
    public function updateprofile(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = [
            'user_name' => $request->user_name,
            'post_num' => $request->post_num,
            'address' => $request->address,
            'building' => $request->building,
        ];

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile', 'public');
            $data['image'] = $path;
        }

        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            $data
        );

        return redirect('/?tab=mylist');
    }
}
