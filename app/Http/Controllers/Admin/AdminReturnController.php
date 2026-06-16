<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderReturn;
use Illuminate\Http\Request;

class AdminReturnController extends Controller
{
    public function index()
    {
        $returns = OrderReturn::with(['order', 'user'])->latest()->paginate(20);
        return view('admin.returns.index', compact('returns'));
    }

    public function update(Request $request, OrderReturn $return)
    {
        $data = $request->validate([
            'status'     => 'required|in:pending,approved,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);
        $return->update($data);
        return redirect()->back()->with('success', 'Return request updated.');
    }
}
