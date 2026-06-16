<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderNoteController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate(['message' => 'required|string|max:1000']);

        // Customer can only post on their own orders
        if (!Auth::user()->is_admin && $order->user_id !== Auth::id()) {
            abort(403);
        }

        OrderNote::create([
            'order_id' => $order->id,
            'user_id'  => Auth::id(),
            'is_admin' => Auth::user()->is_admin,
            'message'  => $request->message,
        ]);

        return redirect()->back()->with('success', 'Message sent.');
    }
}
