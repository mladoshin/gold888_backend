<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Branch;
use App\Models\City;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $key = $request->get('key');
        $perPage = $request->perPage ?? null;
        $users = User::query();
        $users->when($key, function ($query) use ($key){
                $query->where('name', 'like', '%'.$key.'%');
            })
            ->with('cities', 'branch:id,name')
            ->latest();

        if ($perPage){
            $users = $users->paginate($perPage);
        }else{
            $users = $users->get();
        }
        return UserResource::collection($users);
    }

    public function store(StoreUserRequest $request)
    {
        \DB::beginTransaction();
        try {
            $validatedData = $request->validated();
            $validatedData['password'] = bcrypt($request->password);
            if ($request->hasFile('image')){
                $image = $request->image;
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move('users', $imageName);
                $validatedData['image'] = $imageName;
            }

            $user = User::create($validatedData);

            if (isset($request->cities))
                City::whereIn('id', $request->cities)->update(['user_id' => $user->id]);

            if ($request->branch_id && $user->role == 'branch_director')
                Branch::where('id', $request->branch_id)->update(['user_id' => $user->id]);

            if (!empty($request->branches) && $user->role == 'region_director')
                $user->branches()->attach($request->branches);
            \DB::commit();
            return $this->successResponse($user);
        }catch (\Exception $e){
            \DB::rollBack();
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
        \DB::beginTransaction();
        try {
            if ($request->hasFile('image')){
                $image = $request->image;
                $imageName = time().'.'.$image->getClientOriginalExtension();
                $image->move('users', $imageName);
                $validatedData['image'] = $imageName;
            }
            $user->update($validatedData);

            if (isset($request->cities))
                City::whereIn('id', $request->cities)->update(['user_id' => $user->id]);

            if ($request->branch_id && $user->role == 'branch_director')
                Branch::where('id', $request->branch_id)->update(['user_id' => $user->id]);

            if (!empty($request->branches) && $user->role == 'region_director')
                $user->branches()->sync($request->branches);
            \DB::commit();
            return $this->successResponse($user);
        }catch (\Exception $e){
            \DB::rollBack();
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        $this->successResponse();
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'new_password' => 'required|min:6',
        ]);
        $user = User::find($request->user_id);
        $user->update(['password' => bcrypt($request->new_password)]);
        return $this->successResponse();
    }

}
