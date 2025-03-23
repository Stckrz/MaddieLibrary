<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Patron;

class PatronController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Patron::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Received request data:', $request->all());
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'card_number' => 'required|string|unique:patrons,card_number|max:50',
            'email' => 'nullable|email',
        ]);
        return Patron::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Patron $patron)
    {
        return $patron;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patron $patron)
    {
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'card_number' => 'required|string|max:50',
            'email' => 'nullable|email',
        ]);

        $patron->update($validated);
        return $patron;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patron $patron)
    {
        $patron->delete();
        return response()->json(['message' => 'Patron deleted successfully']);
    }
}
