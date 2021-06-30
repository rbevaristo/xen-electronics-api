<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseUtil;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return ResponseUtil::successJsonResponse(Category::orderBy('sort')->orderBy('name')->get());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $cid
     * @return JsonResponse
     */
    public function show($cid)
    {
        $category = Category::find($cid);
        if (!$category) {
            return ResponseUtil::errorJsonResponse('category does not exist', 400);
        }

        return ResponseUtil::successJsonResponse($category->products);
    }

}
