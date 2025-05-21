<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $this->authorize('review', $order);

        $request->validate([
            'seller_rating' => ['required_without:courier_rating', 'integer', 'min:1', 'max:5'],
            'seller_review' => ['nullable', 'string'],
            'courier_rating' => ['required_without:seller_rating', 'integer', 'min:1', 'max:5'],
            'courier_review' => ['nullable', 'string'],
        ]);

        $review = new Review([
            'order_id' => $order->id,
            'customer_id' => auth()->id(),
            'seller_id' => $order->seller_id,
            'courier_id' => $order->courier_id,
            'seller_rating' => $request->seller_rating,
            'seller_review' => $request->seller_review,
            'courier_rating' => $request->courier_rating,
            'courier_review' => $request->courier_review,
        ]);

        $review->save();

        return redirect()->route('orders.show', $order)
            ->with('success', 'Umpan balik berhasil dikirim.');
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'seller_rating' => ['required_without:courier_rating', 'integer', 'min:1', 'max:5'],
            'seller_review' => ['nullable', 'string'],
            'courier_rating' => ['required_without:seller_rating', 'integer', 'min:1', 'max:5'],
            'courier_review' => ['nullable', 'string'],
        ]);

        $review->update([
            'seller_rating' => $request->seller_rating,
            'seller_review' => $request->seller_review,
            'courier_rating' => $request->courier_rating,
            'courier_review' => $request->courier_review,
        ]);

        return redirect()->route('orders.show', $review->order)
            ->with('success', 'Umpan balik berhasil diperbarui.');
    }
} 