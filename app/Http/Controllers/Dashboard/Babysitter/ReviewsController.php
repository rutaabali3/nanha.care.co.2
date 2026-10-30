<?php

namespace App\Http\Controllers\Dashboard\Babysitter;

use App\Models\Babysitting\BabysitterReview;
use App\Models\System\FlaggedItem;
use Illuminate\Http\Request;

class ReviewsController
{
    public function index()
    {
        $reviews = BabysitterReview::where('babysitter_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('dashboard.babysitter.reviews.index', compact('reviews'));
    }

    public function reply(Request $request, $id)
    {
        $review = BabysitterReview::findOrFail($id);

        if ((int) $review->babysitter_id !== (int) auth()->id()) {
            abort(403);
        }

        $request->validate(['reply' => 'required|string']);
        $review->update(['reply' => $request->reply]);

        return redirect()->back()->with('success', 'Reply submitted.');
    }

    public function flag($id)
    {
        $review = BabysitterReview::findOrFail($id);

        FlaggedItem::create([
            'reporter_id' => auth()->id(),
            'flaggable_id' => $review->id,
            'flaggable_type' => BabysitterReview::class,
            'reason' => request('reason', 'Inappropriate content'),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Review flagged for moderation.');
    }
}
