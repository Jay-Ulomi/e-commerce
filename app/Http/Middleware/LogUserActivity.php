<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Events\UserActivityLogged;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Exclude specific routes from logging
        if (
            $request->routeIs('login') ||
            $request->routeIs('logout') ||
            $request->routeIs('products_index') ||
            $request->routeIs('purchase')
        ) {
            return $next($request);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'activity_type' => 'required|in:login,logout,product_view,product_purchase',
            'product_id' => 'nullable|exists:products,id',
            'purchase_amount' => 'required_if:activity_type,product_purchase|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        if ($request->routeIs('products_index')) {
            $request->merge(['activity_type' => 'product_view']);
        }

        // Dispatch an event to log user activities
        event(new UserActivityLogged(
            $request->input('user_id'),
            $request->input('activity_type'),
            $request->input('product_id'),
            $request->input('purchase_amount')
        ));

        return $next($request);
    }
}
