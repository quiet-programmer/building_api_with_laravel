<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function allProducts()
    {
        return response()->json([
            'message' => 'All Products',
            'data' => Products::paginate(5),
        ], 200);
    }

    public function storeProducts(Request $request) {
        if(is_null($request->name)) {
            return response()->json([
                'message' => 'Name cannot be empty',
            ], 400);
        }
        if(is_null($request->price)) {
            return response()->json([
                'message' => 'Price cannot be empty',
            ], 400);
        }
        if(!is_numeric($request->price)) {
            return response()->json([
                'message' => 'Price must be a number',
            ], 400);
        }

        Products::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => Products::all(),
        ], 201);
    }

    public function searchProduct($name) {
        if(is_null($name)) {
            return response()->json([
                'message' => 'Sorry you cannot do that',
            ], 400);
        }

        return response()->json([
            'message' => 'Searched Product',
            'data' => Products::where('name', 'like', '%'. $name)->get(),
        ], 200);
    }
}
