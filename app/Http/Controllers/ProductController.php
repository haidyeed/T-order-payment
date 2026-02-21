<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function viewProducts()
    {
        $products = Product::paginate(10, ['*'], 'productpage');
        return response()->json([ 'success' => true, 'data' => $products]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProductRequest  $request
     */
    public function store(StoreProductRequest $request)
    {

        $product = new Product;
        $product->name = $request->name;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->order = $request->order ?? 0;
        $request->status ? $product->status = 1 : $product->status = 0;

        $product->save();

         return response()->json(['success' => "Product successfully created." ,'product'=>$product], 200);;
    }


}