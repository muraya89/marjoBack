<?php

namespace App\Http\Controllers\cars;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

class CarController extends Controller
{
    public function index(Request $requst)
    {
        try {
            return response()->json(Car::all());
        } catch (\Exception $e) {
            return $e;
        }
    }

    public function store(Request $request)
    {
        try {
            $currentYear = date('Y');
            $validated = $request->validate([
                'model' => 'required',
                'brand' => 'required',
                'seats' => 'required|numeric',
                'transmission' => 'required',
                'fuel_type' => 'nullable',
                'mileage' => 'nullable|numeric',
                'year' => 'required|numeric|max:'.intval($currentYear),
                'status' => 'required',
                'color' => 'required',
                'location_id' => 'required'
            ]);
            $car = Car::create($validated);
            $car->save();
            return response()->json([
                'success' => Response::HTTP_CONTINUE,
                'message' => 'Successfully added a car',
                'data' => $car
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json($e,Response::HTTP_BAD_REQUEST);
        }
    }
}
