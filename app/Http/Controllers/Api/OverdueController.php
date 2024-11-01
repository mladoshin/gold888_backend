<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OverdueResource;
use App\Models\Overdue;
use App\Models\OverdueStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OverdueController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:' . (new User())->getTable() . ',id',
            'status' => 'string|in:' . implode(',', OverdueStatus::getStatusList()),
            'amount' => 'numeric|min:0',
            'returned' => 'numeric|min:0',
            'result' => 'string|nullable',
            'return_date' => 'date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        try {
            $item = Overdue::create($request->all());
            return new OverdueResource($item);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'overdue_id'=> 'required|integer|exists:' . (new Overdue())->getTable() . ',id',
            'user_id' => 'required|integer|exists:' . (new User())->getTable() . ',id',
            'status' => 'string|in:' . implode(',', OverdueStatus::getStatusList()),
            'amount' => 'numeric|min:0',
            'returned' => 'numeric|min:0',
            'result' => 'string|nullable',
            'return_date' => 'date',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 400);
        }
        try {

            $item = Overdue::find($request->input('overdue_id'));
            $item->update($request->except('overdue_id'));
            return new OverdueResource($item);
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

    public function statusList()
    {
        return response()->json(OverdueStatus::getStatusList());
    }

    public function list(Request $request)
    {
        $query = Overdue::query();

        if ($request->filled('search')) {
            $search = mb_strtolower($request->input('search'));
            $userIds = User::whereRaw('LOWER(name) LIKE ?', ["%{$search}%"])
                ->orWhere('surname', 'like', '%' . $request->input('search') . '%')
                ->pluck('id');
            $query->whereIn('user_id', $userIds);
        }

        if ($request->filled('filter-status')) {
            $query->where('status', $request->input('filter-status'));
        }

        if ($request->filled('filter-amount-from')) {
            $query->where('amount', '>=', $request->input('filter-amount-from'));
        }
        if ($request->filled('filter-amount-to')) {
            $query->where('amount', '<=', $request->input('filter-amount-to'));
        }

        if ($request->filled('filter-returned-from')) {
            $query->where('returned', '>=', $request->input('filter-returned-from'));
        }
        if ($request->filled('filter-returned-to')) {
            $query->where('returned', '<=', $request->input('filter-returned-to'));
        }

        $list = $query->orderBy('id', 'desc')->paginate(10);

        return OverdueResource::collection($list);
    }

    public function item($id)
    {
        $item = Overdue::find($id);
        if(!$item) {
            return response()->json([
                'status' => 'error',
                'message' => "The record is missing from the database",
            ], 400);
        }

        return new OverdueResource($item);
    }

    public function del($id)
    {
        $item = Overdue::find($id);
        if(!$item) {
            return response()->json([
                'status' => 'error',
                'message' => "The record is missing from the database",
            ], 400);
        }

        $item->delete($item);

        return response()->json([
            'status' => 'success',
            'message' => "The record is delete success",
        ], 200);
    }
}
