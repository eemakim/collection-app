<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function all(Request $request)
    {
        // to allow search in all cars results
        $search = $request->search;
        $hidden = ['number_plate', 'weight', 'electric'];

        // using whereAny to search in all specified fields and return the search results
        if ($search) {
            return response()->json([
                'message' => 'Products returned',
                'data' => Car::whereAny([
                    'make',
                    'model',
                    'year',
                ], 'LIKE', "%$search%")->get()->makeHidden($hidden),
            ]);
        }

        // returning all car results where no search used
        return response()->json([
            'message' => 'Products returned',
            'data' => Car::all()->makeHidden($hidden),
        ]);
    }
}
