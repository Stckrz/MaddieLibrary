<?php

namespace App\Http\Controllers;

use App\Models\UnifiedDistributable;
use Illuminate\Http\Request;

class UnifiedDistributableController extends Controller
{
    //Display a list of distributables
    public function index(Request $request)
    {

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
        if ($request->has('checked_in')) {
            // Convert the parameter to a boolean
            $checkedIn = filter_var($request->input('checked_in'), FILTER_VALIDATE_BOOLEAN);
            $query->where('checked_in', $checkedIn);
        }

        $distributables = $query->get();
        return response()->json($distributables);
    }

    public function show(UnifiedDistributable $distributable)
    {
        return response()->json($distributable);
    }

}
