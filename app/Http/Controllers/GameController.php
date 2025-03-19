<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Game::query();

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }
            $query->orderBy($sortField, $sortDirection);
        }
        $games = $query->get();
        return response()->json($games);
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
            'studio' => 'nullable|string',
            'platform' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $game = Game::create($validated);
        return response()->json([
            'message' => 'Game Created Successfully',
            'data' => $game
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Game $game)
    {
        return response()->json($game);
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
    public function update(Request $request, Game $game)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'studio' => 'nullable|string',
            'platform' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $game->update($validated);
        return response()->json([
            'message' => 'Game Edited Successfully',
            'data' => $game
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Game $game)
    {
        $game->delete();
        return response()->json([
            'message' => "Game Deleted Successfully",
        ]);
    }
}
