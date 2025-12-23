<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ItemController extends Controller
{
    // 商品一覧/お気に入り画面表示
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $items = Auth::user()->favorites()->with('item.purchase')->get()->pluck('item');
            }
            else {
                $items = collect();
            }
        } else {
            $items = Item::with('purchase')->latest()
                ->when(Auth::check(), function($q) {
                    $q->where('seller_id' , '!=', Auth::id());
                })
                ->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    // 商品詳細画面表示
    public function show($item_id)
    {
        $item = Item::with([
            'categories',
            'condition',
        ])
            ->findOrFail($item_id);

        return view('items.show', compact('item'));
    }

    // 商品出品画面表示
    public function create()
    {
        
    }

    // 商品出品処理
    public function store()
    {
        
    }

    // ログアウト
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
