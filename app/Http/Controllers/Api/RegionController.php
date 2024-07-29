<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $regions = Region::with('director:id,name')->latest()->paginate(10);
        return RegionResource::collection($regions);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'user_id' => 'integer|nullable']);
        try {
            $item = Region::create($request->all());
            return $this->successResponse($item);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show(Region $region)
    {
        return new RegionResource($region);
    }

    public function update(Request $request, Region $region)
    {
        $request->validate(['name' => 'required', 'user_id' => 'integer|nullable']);
        try {
            $region->update($request->all());
            return $this->successResponse($region);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Region $region)
    {
        $region->delete();
        $this->successResponse();
    }
}
