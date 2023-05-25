<?php

namespace App\Http\Controllers\cars;

use Exception;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

            if($request->hasFile('images')) {
                $files = $request->file('images');
                $images = [];

                foreach($files as $index => $file) {
                    $path = $file->storeAs('public/car_images/car'.$car->id, $car->id.'.'.$index.'_carImage.'.$file->getClientOriginalExtension());
                    $images[] = $path;
                }                
                $car->image = json_encode($images);
            }

            $car->save();
            return response()->json([
                'success' => Response::HTTP_CONTINUE,
                'message' => 'Successfully added a car',
                'data' => $car
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['success'=> false , 'error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $car = Car::findOrFail($id);
            $data = $request->all();

            if($request->hasFile('images')){
                $files= $request->file('images');
                $images = [];

                foreach ($files as $index => $file) {
                    $filename = $id.'.'.$index.'_carImages.'.$file->getClientOriginalExtension();
                    
                    if(Storage::exists($filename))
                        Storage::delete($filename);
                    $path = $file->storeAs('public/car_images/car'.$id, $filename);
                    $images[] = $path;
                }
                $data['image'] = json_encode($images);
                    
            }
            
            $car->update($data);
    
            return response()->json([
                'success' => Response::HTTP_OK,
                'message' => 'Car successfully updated',
                'data' => $car
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
    
            return response()->json(['success'=> false , 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
