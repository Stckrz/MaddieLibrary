<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            $query->orderBy($sortField, $sortDirection);
        }

        $books = $query->get();
        return response()->json($books);
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
            'author' => 'nullable|string',
            'published_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'isbn' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $book = Book::create($validated);
        return response()->json([
            'message' => 'Book Created Successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return response()->json($book);
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
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'sometimes|required',
            'author' => 'nullable|string',
            'published_date' => 'nullable|date',
            'synopsis' => 'nullable|string',
            'isbn' => 'nullable|string',
            'checked_in' => 'required|boolean',
        ]);
        $book->update($validated);
        return response()->json([
            'message' => 'Book Edited Successfully',
            'data' => $book
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json([
            'message' => "Book Deleted Successfully",
        ]);
    }
}
