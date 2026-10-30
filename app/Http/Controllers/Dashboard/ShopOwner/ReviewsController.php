<?php

namespace App\Http\Controllers\Dashboard\ShopOwner;

use App\Models\Marketplace\ProductReview;
use App\Models\System\FlaggedItem;
use Illuminate\Http\Request;

class ReviewsController
{
    public function index()
    {
        $userId = auth()->id();
        $reviews = ProductReview::whereHas('product.shop', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['product', 'user'])->paginate(20);

        return view('dashboard.shop-owner.reviews.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $review = ProductReview::findOrFail($id);
        $review->update(['reply' => $request->reply]);

        return redirect()->back()->with('success', 'Reply submitted successfully.');
    }

    public function flag($id)
    {
        $review = ProductReview::findOrFail($id);

        FlaggedItem::create([
            'reporter_id' => auth()->id(),
            'flaggable_id' => $review->id,
            'flaggable_type' => ProductReview::class,
            'reason' => 'Flagged by shop owner',
            'status' => 'pending',
        ]);

        $review->update(['is_flagged' => true]);

        return redirect()->back()->with('success', 'Review has been flagged for moderation.');
    }
}
