<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $items = Wishlist::where('user_id', Auth::id())->with('product.category')->get();
        return view('wishlist.index', compact('items'));
    }

    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);
        $existing = Wishlist::where('user_id', Auth::id())->where('product_id', $request->product_id)->first();
        if ($existing) {
            $existing->delete();
            $msg = 'Removed from wishlist.';
        } else {
            Wishlist::create(['user_id' => Auth::id(), 'product_id' => $request->product_id]);
            $msg = 'Added to wishlist!';
        }
        return redirect()->back()->with('success', $msg);
    }
}
