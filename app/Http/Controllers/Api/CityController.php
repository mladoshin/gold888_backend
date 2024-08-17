<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        return CityResource::collection(City::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['integer', 'nullable'],
            'region_id' => ['nullable', 'integer'],
            'name' => ['required'],
        ]);

        $city = City::create($data);
        return new CityResource($city);
    }

    public function show(City $city)
    {
        return new CityResource($city);
    }

    public function update(Request $request, City $city)
    {
        $data = $request->validate([
            'region_id' => ['nullable', 'integer'],
            'user_id' => ['integer', 'nullable'],
            'name' => ['required'],
        ]);

        $city->update($data);

        return new CityResource($city);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return response()->json();
    }
}
