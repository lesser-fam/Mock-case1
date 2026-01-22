<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    // 商品一覧/お気に入り画面表示
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (Auth::check()) {
                $items = Auth::user()
                    ->favorites()
                    ->whereHas('item', function ($q) use ($keyword) {
                        $this->search($q, $keyword);
                    })
                    ->with('item.purchase')
                    ->get()
                    ->pluck('item');
            }
            else {
                $items = collect();
            }
        } else {
            $query = Item::with('purchase')->latest();

            if (Auth::check()) {
                $query->where('seller_id' , '!=', Auth::id());
            }

            $items = $this->search($query, $keyword)->get();
        }

        return view('items.index', compact('items', 'tab', 'keyword'));
    }

    // 商品詳細画面表示
    public function show($item_id)
    {
        $item = Item::with([
            'categories',
            'condition',
            'favorites',
            'comments.user.profile',
        ])->findOrFail($item_id);

        $isFavorited = false;

        if (Auth::check()) {
            $isFavorited = $item->favorites()
                ->where('user_id', Auth::id())
                ->exists();
        }

        return view('items.show', compact('item', 'isFavorited'));
    }

    // いいね
    public function favorite($item_id)
    {
        $item = Item::findOrFail($item_id);
        $user = Auth::user();

        $favorite = $item->favorites()
            ->where('user_id', $user->id)
            ->first();

        if ($favorite) {
            $favorite->delete();
        }else {
            $item->favorites()->create([
                'user_id' => $user->id,
            ]);
        }

        return back();
    }

    // コメント
    public function comment(CommentRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        $item->comments()->create([
            'user_id' => Auth::id(),
            'detail' => $request->detail,
        ]);

        return back();
    }

    // 商品出品画面表示
    public function create()
    {
        $categories = Category::all();
        $conditions = Condition::all();

        return view('items.create', compact('categories', 'conditions'));
    }

    // 商品出品処理
    public function store(ExhibitionRequest $request)
    {
        // 画像
        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
        }

        $item = Item::create([
            'seller_id' => auth()->id(),
            'name' => $request->name,
            'brand' => $request->brand,
            'detail' => $request->detail,
            'price' => $request->price,
            'condition_id' => $request->condition,
            'image' => $path,
        ]);

        $item->categories()->attach($request->categories);

        return redirect()->route('items.show', $item->id);
    }

    private function search($query, $keyword)
    {
        if (!empty($keyword)) {
            $query->where('name', 'like', '%'. $keyword . '%');
        }

        return $query;
    }
}