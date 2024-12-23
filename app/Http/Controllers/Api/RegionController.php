<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegionResource;
use App\Models\Region;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $key = $request->get('key');
        $perPage = $request->perPage ?? null;
        $regions = Region::query();
        $regions->when($key, function ($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%');
            })
            ->with('director:id,name')
            ->latest();
        if ($perPage){
            $regions = $regions->paginate($perPage);
        }else{
            $regions = $regions->get();
        }

        return RegionResource::collection($regions);
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
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
        $request->validate(['name' => 'required']);
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
