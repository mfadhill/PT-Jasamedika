<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();
        $cars = Car::where('user_id', $userId)->get();
        return response()->json($cars);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|integer|unique:cars,plate_number,NULL,NULL,user_id,' . Auth::id(),
            'daily_rate' => 'required|numeric',
            'available' => 'required|boolean',
        ]);

        $userId = Auth::id();

        $car = Car::create([
            'brand' => $request->brand,
            'model' => $request->model,
            'plate_number' => $request->plate_number,
            'daily_rate' => $request->daily_rate,
            'available' => $request->available,
            'user_id' => $userId,
        ]);

        return response()->json($car, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $userId = Auth::id();
        $car = Car::where('id', $id)->where('user_id', $userId)->firstOrFail();
        return response()->json($car);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $userId = Auth::id();
        $car = Car::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|integer|unique:cars,plate_number,' . $id . ',id,user_id,' . $userId,
            'daily_rate' => 'required|numeric',
            'available' => 'required|boolean',
        ]);

        $car->update($request->only(['brand', 'model', 'plate_number', 'daily_rate', 'available']));

        return response()->json($car);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $userId = Auth::id();
        $car = Car::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $car->delete();

        return response()->json(null, 204);
    }

    /**
     * Search cars based on brand, model, or availability.
     */
    public function search(Request $request)
    {
        $userId = Auth::id();
        $query = Car::where('user_id', $userId);

        if ($request->has('brand')) {
            $query->where('brand', 'like', '%' . $request->brand . '%');
        }

        if ($request->has('model')) {
            $query->where('model', 'like', '%' . $request->model . '%');
        }

        if ($request->has('available')) {
            $query->where('available', (bool) $request->available);
        }

        $cars = $query->get();
        return response()->json($cars);
    }
}
