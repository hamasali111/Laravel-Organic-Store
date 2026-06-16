<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->is_admin) abort(403);
        $order->load('items.product', 'orderNotes.user', 'returns');
        return view('orders.show', compact('order'));
    }
}
