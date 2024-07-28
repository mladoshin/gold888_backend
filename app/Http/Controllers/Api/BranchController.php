<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Resources\BranchResource;
use App\Models\Branch;
use App\Traits\ApiResponse;

class BranchController extends Controller
{
    use ApiResponse;
    public function index()
    {
        $branches = Branch::with('region:id,name', 'director:id,name')->paginate(10);
        return BranchResource::collection($branches);
    }

    public function store(StoreBranchRequest $request)
    {
        try {
            $item = Branch::create($request->validated());
            return $this->successResponse($item);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show(Branch $branch)
    {
        return new BranchResource($branch);
    }

    public function update(StoreBranchRequest $request, Branch $branch)
    {
        try {
            $branch->update($request->validated());
            return $this->successResponse($branch);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(Branch $branch)
    {
        try {
            $branch->delete();
            return $this->successResponse();
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }
}
