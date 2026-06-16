<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Coupon::create($data);
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created.');
    }

    public function edit(Coupon $coupon)
    {
        return view('admin.coupons.form', compact('coupon'));
    }

    public function update(Request $request, Coupon $coupon)
    {
        $coupon->update($this->validated($request));
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon updated.');
    }

    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'code'           => 'required|string|max:30',
            'type'           => 'required|in:percent,fixed',
            'value'          => 'required|numeric|min:0',
            'min_order'      => 'nullable|numeric|min:0',
            'uses_left'      => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'expires_at'     => 'nullable|date',
        ]);
        $data['active']         = $request->boolean('active', true);
        $data['min_order']      = $data['min_order'] ?? 0;
        $data['per_user_limit'] = $data['per_user_limit'] ?? 1;
        $data['code']           = strtoupper(trim($data['code']));
        return $data;
    }
}
