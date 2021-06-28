<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseUtil;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $products = Product::all();

        return ResponseUtil::successJsonResponse($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = $this->validateProductRequest($request);

        if ($validator->fails()) {
            return ResponseUtil::errorJsonResponse($validator->errors(), 400);
        }

        $category = Category::find($request->get('category'));

        if (!$category) {
            return ResponseUtil::errorJsonResponse('category does not exist', 400);
        }

        if ($category->products()->whereName($request->get('name'))->first()) {
            return ResponseUtil::errorJsonResponse('Product already exist', 400);
        }

        $product = $category->products()->create([
            'name' => $request->get('name'),
            'description' => $request->get('description'),
            'price' => $request->get('price'),
            'quantity' => $request->get('quantity')
        ]);

        return ResponseUtil::successJsonResponse($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $pid
     * @return JsonResponse
     */
    public function show($pid)
    {
        $product = Product::find($pid);
        if (!$product) {
            return ResponseUtil::errorJsonResponse('Product does not exist', 400);
        }

        return ResponseUtil::successJsonResponse($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = $this->validateProductRequest($request);

        if ($validator->fails()) {
            return ResponseUtil::errorJsonResponse($validator->errors(), 400);
        }

        $product = Product::find($id);
        if (!$product) {
            return ResponseUtil::errorJsonResponse('Product does not exist', 400);
        }

        $category = Category::find($request->get('category'));

        if (!$category) {
            return ResponseUtil::errorJsonResponse('category does not exist', 400);
        }

        $product->category_id = $category->id;
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->price = $request->get('price');
        $product->quantity = $request->get('quantity');
        $product->save();

        return ResponseUtil::successJsonResponse($product);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateProductRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category' => 'required|numeric'
        ]);
    }
}
