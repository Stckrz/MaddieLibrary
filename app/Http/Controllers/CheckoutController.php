<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;

class CheckoutController extends Controller
{
    //function to create a new checkOut item
    public function checkOut(Request $request)
    {
        //validate the request data
        $validated = $request->validate([
            'patron_id'         => 'required|exists:patrons,id',
            'distributable_id'  => 'required|exists:distributables,id',
        ]);

        //find a checkout where the distributable_id matches the one in the request, otherwise create a new one
        $checkout = Checkout::where('distributable_id', $validated['distributable_id'])->first();

        if ($checkout) {
            return response()->json([
                'error' => 'This item is already checked out.'
            ], 422);
        }

        //create a new checkout
        $checkout = Checkout::create([
            'distributable_id' => $validated['distributable_id'],
            'patron_id'        => $validated['patron_id'],
            'checked_out_at'   => now(),
        ]);

        return response()->json([
            'message' => 'Game has been checked out successfully.',
            'data'    => $checkout,
        ], 201);
    }

    //takes an id, and deletes a checkOut if it exists.
    public function checkIn($id)
    {
        $checkout = Checkout::where('distributable_id', $id)->first();
        if (!$checkout) {
            return response()->json([
                'error' => 'This item is not currently checked out.'
            ], 422);
        }
        $checkout->checkIn();
        return response()->json([
            'message' => 'Item successfully checked in'
        ]);
    }

    //This would return all current checkouts
    public function index()
    {
        $checkouts = Checkout::all();
        return response()->json([
            'data' => $checkouts,
        ]);
    }
}
