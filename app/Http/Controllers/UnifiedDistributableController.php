<?php

namespace App\Http\Controllers;

use App\Models\UnifiedDistributable;
use Illuminate\Http\Request;

class UnifiedDistributableController extends Controller
{
    //Display a list of distributables
    public function index(Request $request)
    {
        $offset = $request->input('offset', 0);
        $limit = $request->input('limit', 10);

        //query parameters for displaying all of a certain type
        $query = UnifiedDistributable::query();
        if ($request->has('type')) {
            $query->where('type', $request->input('type'));
        }

        //
        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }

        // Example of filtering by "checked_in"
        // if ($request->has('checked_in')) {
            // Convert the parameter to a boolean
        //     $checkedIn = filter_var($request->input('checked_in'), FILTER_VALIDATE_BOOLEAN);
        //     $query->where('checked_in', $checkedIn);
        // }
        //sorting logic
        if ($request->has('sort_by')) {
            $sortField = $request->input('sort_by');
            $sortDirection = $request->input('sort_order', 'asc'); // Default to ascending if not specified

            // Validate sort direction
            if (!in_array($sortDirection, ['asc', 'desc'])) {
                $sortDirection = 'asc';
            }

            $query->orderBy($sortField, $sortDirection);
        }

        $distributables = $query->skip($offset)->take($limit)->get();

        return response()->json($distributables);
    }

    public function show(UnifiedDistributable $distributable)
    {
        return response()->json($distributable);
    }
}
