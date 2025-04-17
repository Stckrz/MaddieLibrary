<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class MovieController extends BaseController
{
    public function __construct()
    {
        // Only store, update and destroy require an authenticated Sanctum token
        $this->middleware('auth:sanctum')
             ->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        $query = Movie::query();

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            $query->orderBy($sortField, $sortDirection);
        }

        $movies = $query->skip($offset)->take($limit)->get();
        return response()->json($movies);
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
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'img_url' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);
        $movie = Movie::create($validated);
        return response()->json([
            'message' => 'Movie Created Successfully',
            'data' => $movie
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie)
    {
        return response()->json($movie);
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
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'platform' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'img_url' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);
        $movie->update($validated);
        return response()->json([
            'message' => 'Movie Edited Successfully',
            'data' => $movie
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();
        return response()->json([
            'message' => "Movie Deleted Successfully",
        ]);
    }
}
