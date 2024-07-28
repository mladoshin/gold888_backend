<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('region', 'branch')->get();
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = bcrypt($request->password);
        if ($request->hasFile('image')){
            $image = $request->image;
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move('users', $imageName);
            $validatedData['image'] = $imageName;
        }
        $user = User::create($validatedData);
        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validatedData = $request->validated();
        if ($request->filled('password'))
            $validatedData['password'] = bcrypt($request->password);

        if ($request->hasFile('image')){
            $image = $request->image;
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move('users', $imageName);
            $validatedData['image'] = $imageName;
        }
        $user->update($validatedData);

        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'user deleted']);
    }
}
