<?php

namespace App\Http\Controllers;

use App\Models\Show;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ShowController extends BaseController
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

        $query = Show::query();

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            $query->orderBy($sortField, $sortDirection);
        }

        $shows = $query->skip($offset)->take($limit)->get();
        return response()->json($shows);
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
        $show = Show::create($validated);
        return response()->json([
            'message' => 'Show Created Successfully',
            'data' => $show
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Show $show)
    {
        return response()->json($show);
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
    public function update(Request $request, Show $show)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'platform' => 'nullable|string',
            'release_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'img_url' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);
        $show->update($validated);
        return response()->json([
            'message' => 'Show Edited Successfully',
            'data' => $show
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Show $show)
    {
        $show->delete();
        return response()->json([
            'message' => "Show Deleted Successfully",
        ]);
    }
    //
}
