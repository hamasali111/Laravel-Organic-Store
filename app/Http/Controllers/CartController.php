<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected function sessionId(): string
    {
        return session()->getId();
    }

    public function index()
    {
        $items    = CartItem::where('session_id', $this->sessionId())->with('product.category')->get();
        $subtotal = $items->sum(fn($i) => $i->product->price * $i->quantity);
        $coupon   = session('coupon');
        $discount = 0;
        if ($coupon) {
            $c = Coupon::where('code', $coupon)->first();
            $discount = $c ? $c->discount($subtotal) : 0;
        }
        $total = $subtotal - $discount;
        return view('cart.index', compact('items', 'subtotal', 'discount', 'total', 'coupon'));
    }

    public function add(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id', 'quantity' => 'integer|min:1']);
        $product = Product::findOrFail($request->product_id);
        $qty = (int)($request->quantity ?? 1);
        $item = CartItem::firstOrCreate(
            ['session_id' => $this->sessionId(), 'product_id' => $product->id],
            ['quantity' => 0]
        );
        $item->quantity += $qty;
        $item->save();
        return redirect()->back()->with('success', "{$product->name} added to cart!");
    }

    public function update(Request $request)
    {
        $request->validate(['item_id' => 'required|exists:cart_items,id', 'quantity' => 'required|integer|min:1']);
        CartItem::where('id', $request->item_id)->where('session_id', $this->sessionId())->update(['quantity' => $request->quantity]);
        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(Request $request)
    {
        CartItem::where('id', $request->item_id)->where('session_id', $this->sessionId())->delete();
        return redirect()->route('cart.index')->with('success', 'Item removed.');
    }

    public function applyCoupon(Request $request)
    {
        $request->validate(['code' => 'required|string']);
        $code   = strtoupper(trim($request->code));
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon || !$coupon->isValid()) {
            return redirect()->route('cart.index')->with('error', 'Invalid or expired coupon code.');
        }

        // Per-user check: only for logged-in users
        if (Auth::check() && $coupon->hasBeenUsedByUser(Auth::id())) {
            return redirect()->route('cart.index')->with('error', 'You have already used this coupon.');
        }

        session(['coupon' => $coupon->code]);
        return redirect()->route('cart.index')->with('success', 'Coupon applied! ' . ($coupon->type === 'percent' ? $coupon->value . '% off' : 'Rs ' . $coupon->value . ' off') . ' your order.');
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return redirect()->route('cart.index')->with('success', 'Coupon removed.');
    }
}
