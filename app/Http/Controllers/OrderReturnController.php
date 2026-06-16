<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderReturnController extends Controller
{
    public function create(Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);
        if (!in_array($order->status, ['delivered'])) {
            return redirect()->route('orders.show', $order->id)
                ->with('error', 'Returns can only be requested for delivered orders.');
        }
        $existing = $order->returns()->first();
        return view('orders.returns.create', compact('order', 'existing'));
    }

    public function store(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) abort(403);

        $data = $request->validate([
            'reason'  => 'required|string|max:255',
            'details' => 'nullable|string|max:1000',
        ]);

        OrderReturn::updateOrCreate(
            ['order_id' => $order->id, 'user_id' => Auth::id()],
            [...$data, 'status' => 'pending']
        );

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Return request submitted. We will review it shortly.');
    }
}
