<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\ProductResource;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;

class ProductController extends BaseController
{
    public function index() : JsonResponse {
        $products = Product::all();
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }

    public function store(Request $request){
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'title' => 'required',
            'slogan' => 'required',
            'description' => 'required',
            'button_link' => 'required',
            'button_text' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $product = Product::create($inputs);
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }

    public function show($id): JsonResponse
    {
        $product = Product::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }

    public function update(Request $request, Product $product){
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'title' => 'required',
            'slogan' => 'required',
            'description' => 'required',
            'button_link' => 'required',
            'button_text' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $product->title = $inputs['title'];
        $product->slogan = $inputs['slogan'];
        $product->description = $inputs['description'];
        $product->button_link = $inputs['button_link'];
        $product->button_text = $inputs['button_text'];
        $product->save();

        return $this->sendResponse(new ProductResource($product), 'Product Update successfully.');
    }
}
