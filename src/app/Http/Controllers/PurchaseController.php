<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Purchase;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    // 商品購入画面表示
    public function show($item_id)
    {
        $item = Item::with([
            'categories',
            'condition'
        ])->findOrFail($item_id);

        $profile = Auth::user()->profile;

        $paymentMethods = [
            'convenience' => 'コンビニ支払い',
            'card' => 'カード支払い'
        ];

        $address = session('purchase_address', [
            'post_num' => $profile->post_num,
            'address' => $profile->address,
            'building' => $profile->building,
        ]);

        return view('purchases.show', compact(
            'item',
            'paymentMethods',
            'address',
        ));
    }

    // 商品購入処理
    public function store(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);

        if ($item->purchase && $item->purchase->status === 'paid') {
            abort(403);
        }

        $validated = $request->validated();

        $purchase = Purchase::create([
            'buyer_id' => Auth::id(),
            'item_id' => $item->id,
            'payment_method' => $validated['payment_method'],
            'post_num' => $validated['post_num'],
            'address' => $validated['address'],
            'building' => $validated['building'] ?? null,
            'status' => 'paid'
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $paymentMethodTypes = $validated['payment_method'] === 'card' ? ['card'] : ['konbini'];

        $session = Session::create([
            'payment_method_types' => $paymentMethodTypes,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => url('/'),
            'cancel_url' => url('/'),
        ]);
        
        return redirect($session->url);
    }

    // 住所変更画面表示
    public function editaddress($item_id)
    {
        $item = Item::findOrFail($item_id);
        $profile = Auth::user()->profile;

        return view('purchases.edit_address', compact('item', 'profile'));
    }

    // 住所変更処理
    public function updateaddress(AddressRequest $request, $item_id)
    {
        session([
            'purchase_address' => $request->only([
                'post_num',
                'address',
                'building',
            ]),
        ]);

        return redirect()->route('purchase.show', $item_id);
    }
}
