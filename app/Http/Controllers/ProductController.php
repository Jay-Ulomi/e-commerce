<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\UserActivityLog;

class ProductController extends Controller
{
    public function index()
    {

        $products = Product::all();

        return response()->json($products);
    }

    public function create(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);


        $product = Product::create( $validatedData);

        return response()->json($product, 201);
    }

    public function purchase(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);


        UserActivityLog::create([
            'user_id' => auth()->id(),
            'activity_type' => 'product_purchase',
            'product_id' => $product->id,
            'purchase_amount' => $request->input('purchase_amount'),
        ]);



        return response()->json(['message' => 'Product purchased successfully']);
    }
}
