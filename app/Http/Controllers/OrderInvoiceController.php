<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class OrderInvoiceController extends Controller
{
    public function download(Order $order)
    {
        if (!Auth::user()->is_admin && $order->user_id !== Auth::id()) {
            abort(403);
        }
        $order->load('items.product', 'user');
        $pdf = Pdf::loadView('orders.invoice', compact('order'));
        return $pdf->download('invoice-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) . '.pdf');
    }
}
