<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Models\OrderNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminOrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product', 'user', 'orderNotes.user', 'returns');
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Payment status update
        if ($request->has('payment_status')) {
            $request->validate(['payment_status' => 'required|in:pending,verified,rejected']);
            $order->update(['payment_status' => $request->payment_status]);
            return redirect()->back()->with('success', 'Payment status updated.');
        }

        // Order status update
        $data = $request->validate([
            'status'          => 'required|in:pending,confirmed,processing,shipped,delivered,cancelled',
            'tracking_number' => 'nullable|string|max:100',
        ]);

        $oldStatus = $order->status;

        if ($data['status'] === 'shipped' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($data['status'] === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
        }

        $order->update($data);

        if ($oldStatus !== $data['status'] && $data['status'] !== 'pending') {
            try {
                $order->load('items.product');
                Mail::to($order->shipping_email)->send(new OrderStatusMail($order));
            } catch (\Exception $e) {
                Log::error('Order status email failed for order #' . $order->id . ': ' . $e->getMessage());
            }
        }

        // Admin note / message to customer
        if ($request->filled('admin_note')) {
            OrderNote::create([
                'order_id' => $order->id,
                'user_id'  => auth()->id(),
                'is_admin' => true,
                'message'  => $request->admin_note,
            ]);
        }

        return redirect()->back()->with('success', 'Order updated successfully.');
    }
}
