<?php
namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ReviewController extends Controller
{
    // Customer: submit review
    public function store(Request $request)
    {
        $request->validate([
            'item_id'  => 'required|integer',
            'order_id' => 'required|integer',
            'rating'   => 'required|integer|min:1|max:5',
            'comment'  => 'nullable|string|max:1000',
        ]);

        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        if (!$customer) return back()->with('error', 'Customer profile not found.');

        // Verify completed order
        $validOrder = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->where('orders.customer_id', $customer->id)
            ->where('orders.order_id', $request->order_id)
            ->where('orders.status', 'completed')
            ->where('order_items.item_id', $request->item_id)
            ->exists();

        if (!$validOrder) return back()->with('error', 'You can only review products from completed orders.');

        // Check already reviewed
        $alreadyReviewed = Review::where('item_id', $request->item_id)
            ->where('customer_id', $customer->id)
            ->where('order_id', $request->order_id)
            ->exists();

        if ($alreadyReviewed) return back()->with('error', 'You have already reviewed this product.');

        Review::create([
            'item_id'     => $request->item_id,
            'customer_id' => $customer->id,
            'order_id'    => $request->order_id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
        ]);

        return back()->with('success', 'Your review has been submitted.');
    }

    // Customer: update their own review
    public function update(Request $request, $review_id)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $customer = DB::table('customer')->where('user_id', Auth::id())->first();
        if (!$customer) return back()->with('error', 'Customer profile not found.');

        $review = Review::where('review_id', $review_id)
            ->where('customer_id', $customer->id)
            ->first();

        if (!$review) return back()->with('error', 'Review not found or not yours.');

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Your review has been updated.');
    }

    // Admin: list all reviews
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $reviews = DB::table('reviews')
                ->join('customer', 'reviews.customer_id', '=', 'customer.id')
                ->join('item', 'reviews.item_id', '=', 'item.item_id')
                ->select(
                    'reviews.review_id',
                    'reviews.rating',
                    'reviews.comment',
                    'reviews.created_at',
                    'customer.fname',
                    'customer.lname',
                    'item.title as item_title'
                )
                ->orderBy('reviews.created_at', 'desc');

            return DataTables::query($reviews)
                ->addColumn('customer_name', fn($row) => strtoupper($row->fname . ' ' . $row->lname))
                ->addColumn('stars', fn($row) => str_repeat('★', $row->rating) . str_repeat('☆', 5 - $row->rating))
                ->addColumn('date', fn($row) => \Carbon\Carbon::parse($row->created_at)->format('M d, Y'))
                ->addColumn('action', fn($row) => '
                    <form action="' . route('admin.reviews.destroy', $row->review_id) . '" method="POST" onsubmit="return confirm(\'Delete this review?\')">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" class="btn-delete">DELETE</button>
                    </form>
                ')
                ->rawColumns(['stars', 'action'])
                ->make(true);
        }

        return view('dashboard.reviews');
    }

    // Admin: delete a review
    public function destroy($review_id)
    {
        Review::where('review_id', $review_id)->delete();
        return back()->with('success', 'Review deleted.');
    }
}