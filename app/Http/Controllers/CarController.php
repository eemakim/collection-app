<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function all(Request $request)
    {
        $hidden = ['number_plate', 'weight', 'electric'];

        $search = $request->search;
        $sort = $request->sort;
        $request->validate([
            '$sort' => 'in:asc, desc',
        ]);

        $query = Car::whereAny([
            'make',
            'model',
            'year',
        ], 'LIKE', "%$search%");

        // search and sort
        if ($search && $sort) {
            return response()->json([
                'message' => 'Cars returned',
                'data' => $query->orderBy('make', $sort)->get()->makeHidden($hidden),
            ]);
        }

        // just search
        if ($search) {
            return response()->json([
                'message' => 'Cars returned',
                'data' => $query->get()->makeHidden($hidden),
            ]);
        }

        // just sort
        if ($sort) {
            return response()->json([
                'message' => 'Cars ordered in '.$sort.'ending order',
                'data' => $query->orderBy('make', $sort)->get()->makeHidden($hidden),
            ]);
        }

        // returning all car results where no search or sort used
        return response()->json([
            'message' => 'Cars returned',
            'data' => Car::all()->makeHidden($hidden),
        ]);
    }

    public function find(int $id)
    {
        $car = Car::find($id);
        if (! $car) {
            return response()->json([
                'message' => 'Error - car not found',
            ], 400);
        }

        return response()->json([
            'message' => 'Car returned',
            'data' => $car,
        ]);
    }

    public function create(Request $request)
    {
        // validating inputted data
        $request->validate([
            'make' => 'required|string|max:20',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1950|max:2024',
            'number_plate' => 'required|string|max:7|uppercase',
            'weight' => 'nullable|integer|max:3000',
            'electric' => 'required|boolean',
        ]);
        // create a new Car Model
        $car = new Car();
        // add POST data
        $car->make = $request->make;
        $car->model = $request->model;
        $car->year = $request->year;
        $car->number_plate = $request->number_plate;
        $car->electric = $request->electric;

        // check for errors on save
        if (! $car->save()) {
            return response()->json([
                'message' => 'Error - could not add new car',
            ], 500);
        }

        // success message
        return response()->json([
            'message' => 'New car added',
        ]);
    }

    public function update(int $id, Request $request)
    {
        $request->validate([
            'make' => 'string|max:20',
            'model' => 'string|max:50',
            'year' => 'integer|min:1950|max:2024',
            'number_plate' => 'string|max:7|uppercase',
            'weight' => 'nullable|integer|max:3000',
            'electric' => 'boolean',
        ]);
        $car = Car::find($id);
        if (! $car) {
            return response()->json([
                'message' => 'Error - car not found',
            ], 400);
        }

        if ($request->make) {
            $car->make = $request->make;
        }
        if ($request->model) {
            $car->model = $request->model;
        }
        if ($request->year) {
            $car->year = $request->year;
        }
        if ($request->number_plate) {
            $car->number_plate = $request->number_plate;
        }
        if ($request->weight) {
            $car->weight = $request->weight;
        }
        if ($request->electric) {
            $car->electric = $request->electric;
        }
        if (! $car->save()) {
            return response()->json([
                'message' => 'Error - could not update car',
            ], 500);
        }

        return response()->json([
            'message' => 'Car updated successfully',
        ]);
    }

    public function delete(int $id)
    {
        $car = Car::find($id);
        if (! $car) {
            return response()->json([
                'message' => 'Error - car not found',
            ], 400);
        }
        $car->delete();

        return response()->json([
            'message' => 'Car deleted',
        ]);
    }
}
