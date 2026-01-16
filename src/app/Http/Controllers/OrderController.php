<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Item;
use App\Models\UserProfile;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\AddressRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderController extends Controller
{
    public function create($item_id) {
        $paymentMethods = Order::paymentMethods();
        $profile = auth()->user()->profile;
        $item = Item::findOrFail($item_id);
        return view('purchase.create', compact('item', 'paymentMethods', 'profile'));
    }

    public function editAddress($item_id) {
        return view('purchase.shipping_address_edit', compact('item_id'));
    }

    public function updateAddress(AddressRequest $request, $item_id) {
        return redirect()->route('purchase.create', $item_id)->withInput();
    }

    public function store(PurchaseRequest $request, Item $item) {
        $validated = $request->validated();
        $building = $request->input('building');
        if (Order::where('item_id', $item->id)->exists()) {
            abort(403, 'この商品はすでに購入されています。');
        }

        if ($item->user_id === auth()->id()) {
            abort(403, '自分が出品した商品は購入できません。');
        }

        DB::transaction(function () use ($item, $validated, $building) {

            Order::create($validated + [
                'item_id' => $item->id,
                'user_id' => auth()->id(),
                'building' => $building,
            ]);

            $item->update([
                'is_sold' => true,
            ]);
        });

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'payment_method_types' => ['card', 'konbini'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => ['name' => $item->name],
                    'unit_amount' => $item->price,
                ],
                'quantity' => 1,
            ]],
            'success_url' => route('items.index'),
            'cancel_url' => route('items.index'),
        ]);

        return redirect($session->url);
    }
}
