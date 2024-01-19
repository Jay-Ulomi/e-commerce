<?php

namespace App\Http\Controllers;

use App\Models\UserActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $validator = validator($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'activity_type' => 'nullable|in:login,logout,product_view,product_purchase,registration',
            'start_date' => 'date',
            'end_date' => 'date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $query = UserActivityLog::query();

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->activity_type);
        }

        $query->when($request->start_date, function ($query) use ($request) {
            $query->whereDate('created_at', '>=', $request->start_date);
        })
        ->when($request->end_date, function ($query) use ($request) {
            $query->whereDate('created_at', '<=', $request->end_date);
        });

        $logs = $query->get();

        return response()->json($logs);
    }
}
