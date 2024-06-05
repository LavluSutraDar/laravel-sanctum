<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\File;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\Categoryresource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Traits\UploadTrait;

class CategoryController extends BaseController
{
    use UploadTrait;
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        $data = $validator->validated();
        $image = $request->file('image');
        $data['image'] = !empty($image) ? $this->upload($image, 'category') : null;

        $product = Category::create($data);
       return $this->sendResponse(new Categoryresource($product), 'created succes sfully.');
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $data = $validator->validated();
        $image = $request->file('image');
        $data['image'] = !empty($image) ? $this->upload($image, 'category', $category->image) : $this->oldFile($category->image);

        $category->update($data);
        return $this->sendResponse(new Categoryresource($category), 'succes sfully.');
        
    }

    public function show($id)
    {
        $product = Category::find($id);
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        return $this->sendResponse(new Categoryresource($product), 'Product retrieved successfully.');
    }

    
}
