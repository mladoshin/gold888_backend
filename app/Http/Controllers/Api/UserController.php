<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $users = User::with('region', 'branch')->paginate(10);
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $validatedData['password'] = bcrypt($request->password);
            if ($request->hasFile('image')){
                $image = $request->image;
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move('users', $imageName);
                $validatedData['image'] = $imageName;
            }
            $item = User::create($validatedData);
            return $this->successResponse($item);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        try {
            if ($request->filled('password'))
                $validatedData['password'] = bcrypt($request->password);

            if ($request->hasFile('image')){
                $image = $request->image;
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move('users', $imageName);
                $validatedData['image'] = $imageName;
            }
            $user->update($validatedData);
            return $this->successResponse($user);
        }catch (\Exception $e){
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        $this->successResponse();
    }
}
