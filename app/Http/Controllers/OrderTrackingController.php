<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    public function index()
    {
        return view('orders.track');
    }

    public function track(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'email'    => 'required|email',
        ]);

        $order = Order::where('id', ltrim($request->order_id, '#0'))
            ->where('shipping_email', $request->email)
            ->with('items.product')
            ->first();

        if (!$order) {
            return back()->withErrors(['order_id' => 'No order found with that ID and email address.']);
        }

        return view('orders.track', compact('order'));
    }
}
