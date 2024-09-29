<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Village;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function districts(Request $request)
    {
        $selects = ['id', 'name'];

        if ($request->search)
            return response()->json([
                'results' => District::select($selects)->where('name', 'like', "%$request->search%")
            ]);

        if ($request->id)
            return response()->json([
                'results' => District::select($selects)->whereId($request->id)
                    ->first()
            ]);

        return response()->json([
            'results' => District::select($selects)->get()
        ]);
    }

    public function villages(Request $request)
    {
        $selects = ['id', 'name', 'district_id'];
        if ($request->search)
            return response()->json([
                'results' => Village::select($selects)->where('name', 'like', "%$request->search%")->get()
            ]);

        if ($request->id)
            return response()->json([
                'results' => Village::select($selects)->whereId($request->id)
                    ->first()
            ]);

        if ($request->district_id)
            return response()->json([
                'results' => Village::select($selects)->where('district_id', $request->district_id)
                    ->get()
            ]);

        return response()->json([
            'results' => Village::select($selects)->get()
        ]);
    }
}
