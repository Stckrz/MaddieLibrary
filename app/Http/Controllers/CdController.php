<?php

namespace App\Http\Controllers;

use App\Models\Cd;
use Illuminate\Http\Request;

class CdController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Cd::query();

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            $query->orderBy($sortField, $sortDirection);
        }

        $cds = $query->get();
        return response()->json($cds);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'artist' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $cd = Cd::create($validated);
        return response()->json([
            'message' => 'Cd Created Successfully',
            'data' => $cd
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cd $cd)
    {
        return response()->json($cd);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cd $cd)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'artist' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $cd->update($validated);
        return response()->json([
            'message' => 'Cd Edited Successfully',
            'data' => $cd
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cd $cd)
    {
        $cd->delete();
        return response()->json([
            'message' => "Cd Deleted Successfully",
        ]);
    }
}
