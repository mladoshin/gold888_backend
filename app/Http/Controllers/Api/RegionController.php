<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function index()
    {
        return RegionResource::collection(Region::latest()->paginate(10));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'user_id' => 'required']);
        $region = Region::create($request->all());
        return new RegionResource($region);
    }

    public function show(Region $region)
    {
        return new RegionResource($region);
    }

    public function update(Request $request, Region $region)
    {
        $request->validate(['name' => 'required']);
        $region->update($request->all());
        return new RegionResource($region);
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return response()->json(['message' => 'region deleted']);
    }
}
