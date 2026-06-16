<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    const SHIPPING_FEE      = 200;
    const FREE_SHIPPING_MIN = 5000;

    protected function sessionId(): string { return session()->getId(); }

    public function index()
    {
        $items    = CartItem::where('session_id', $this->sessionId())->with('product')->get();
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        $subtotal = $items->sum(fn ($i) => $i->product->price * $i->quantity);
        $coupon   = session('coupon');
        $discount = 0;
        $couponObj = null;
        if ($coupon) {
            $couponObj = Coupon::where('code', $coupon)->first();
            $discount  = $couponObj ? $couponObj->discount($subtotal) : 0;
        }
        $total       = $subtotal - $discount;
        $shippingFee = $total >= self::FREE_SHIPPING_MIN ? 0 : self::SHIPPING_FEE;
        return view('checkout.index', compact('items', 'subtotal', 'discount', 'total', 'coupon', 'shippingFee'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'required|string|max:500',
            'city'           => 'required|string|max:100',
            'zip'            => 'required|string|max:20',
            'notes'          => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,bank,jazzcash,easypaisa',
            'payment_proof'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if (in_array($data['payment_method'], ['bank', 'jazzcash', 'easypaisa'])) {
            $request->validate(['payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120']);
        }

        $items = CartItem::where('session_id', $this->sessionId())->with('product')->get();
        if ($items->isEmpty()) return redirect()->route('cart.index')->with('error', 'Your cart is empty.');

        $subtotal   = $items->sum(fn ($i) => $i->product->price * $i->quantity);
        $couponCode = session('coupon');
        $discount   = 0;
        $couponObj  = null;

        if ($couponCode) {
            $couponObj = Coupon::where('code', $couponCode)->first();
            if ($couponObj) {
                if (Auth::check() && $couponObj->hasBeenUsedByUser(Auth::id())) {
                    session()->forget('coupon');
                    return redirect()->route('cart.index')->with('error', 'This coupon has already been used by your account.');
                }
                $discount = $couponObj->discount($subtotal);
                if ($couponObj->uses_left) $couponObj->decrement('uses_left');
            }
        }

        $total         = $subtotal - $discount;
        $shippingFee   = $total >= self::FREE_SHIPPING_MIN ? 0 : self::SHIPPING_FEE;
        $paymentMethod = $data['payment_method'];

        // Handle proof upload
        $paymentProof = null;
        if ($request->hasFile('payment_proof') && $request->file('payment_proof')->isValid()) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
            $paymentProof = 'storage/' . $path;
        }

        // COD orders are pending payment at door; online transfers await verification
        $paymentStatus = $paymentMethod === 'cod' ? 'pending' : 'pending';

        $order = DB::transaction(function () use ($data, $items, $total, $discount, $couponCode, $couponObj, $shippingFee, $paymentMethod, $paymentProof, $paymentStatus) {
            $order = Order::create([
                'user_id'          => Auth::id() ?? 1,
                'status'           => 'confirmed',
                'total'            => $total + $shippingFee,
                'discount'         => $discount,
                'coupon_code'      => $couponCode,
                'shipping_name'    => $data['name'],
                'shipping_email'   => $data['email'],
                'shipping_phone'   => $data['phone'] ?? null,
                'shipping_address' => $data['address'],
                'shipping_city'    => $data['city'],
                'shipping_zip'     => $data['zip'],
                'notes'            => $data['notes'] ?? null,
                'payment_method'   => $paymentMethod,
                'payment_status'   => $paymentStatus,
                'payment_proof'    => $paymentProof,
                'shipping_fee'     => $shippingFee,
            ]);
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'quantity'   => $item->quantity,
                    'price'      => $item->product->price,
                ]);
                $item->product->decrement('stock', $item->quantity);
            }

            if ($couponObj && Auth::check()) {
                CouponUsage::create([
                    'coupon_id' => $couponObj->id,
                    'user_id'   => Auth::id(),
                    'order_id'  => $order->id,
                ]);
            }

            CartItem::where('session_id', session()->getId())->delete();
            session()->forget('coupon');
            return $order;
        });

        try {
            $order->load('items.product');
            Mail::to($order->shipping_email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::error('Order confirmation email failed for order #' . $order->id . ': ' . $e->getMessage());
        }

        return redirect()->route('checkout.success', $order->id);
    }

    public function success(Order $order)
    {
        $order->load('items.product');
        return view('checkout.success', compact('order'));
    }
}
