<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'rating'       => 'required|integer|min:1|max:5',
            'title'        => 'nullable|string|max:120',
            'body'         => 'nullable|string|max:1000',
            'review_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $data['user_id'] = Auth::id();

        if ($request->hasFile('review_photo') && $request->file('review_photo')->isValid()) {
            $path = $request->file('review_photo')->store('reviews', 'public');
            $data['photo'] = '/storage/' . $path;
        }

        unset($data['review_photo']);

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $data['product_id']],
            $data
        );
        return redirect()->back()->with('success', 'Review submitted. Thank you!');
    }

    public function destroy(Review $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->is_admin) {
            abort(403);
        }
        if ($review->photo) {
            Storage::disk('public')->delete(ltrim(str_replace('/storage/', '', $review->photo), '/'));
        }
        $review->delete();
        return redirect()->back()->with('success', 'Review deleted.');
    }
}
