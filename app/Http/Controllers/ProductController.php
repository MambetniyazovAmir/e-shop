<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return ProductResource::collection($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return ProductResource::make($product);
    }

    public function show(Product $product)
    {
        return ProductResource::make($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return ProductResource::make($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json();
    }

    public function filerByPrice(Request $request)
    {
        $from = $request->from;
        $to = $request->to;
        $cat_id = $request->category_id;
        $length = $request->length;
        $weight = $request->weight;
        $width = $request->width;

        $data = Product::query();

        $data->whereBetween('price', [$from, $to])->when($cat_id, function ($query, $cat_id) {
            return $query->where('category_id', $cat_id);
        })->when($length, function ($query, $length) {
            return $query->where('property->length', $length);
        })->when($weight, function ($query, $weight) {
            return $query->where('property->weight', $weight);
        })->when($width, function ($query, $width) {
            return $query->where('property->width', $width);
        });

        $data = $data->get();
        return ProductResource::collection($data);
    }
}
