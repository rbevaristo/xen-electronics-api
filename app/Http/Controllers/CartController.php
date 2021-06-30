<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseUtil;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

        return ResponseUtil::successJsonResponse($user->carts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $product = Product::find($request->get('product'));

        if (!$product) {
            return ResponseUtil::errorJsonResponse('product does not exist', 400);
        }

        if ($user->carts()->where('product_id', $product->id)->first()) {
            return ResponseUtil::errorJsonResponse('product already in cart', 400);
        }

        $user->carts()->create(['product_id' => $request->get('product')]);
        return ResponseUtil::successJsonResponse($user->carts, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $pid
     * @return JsonResponse
     */
    public function destroy($pid)
    {
        $user = auth()->user();

        $cart = $user->carts()->where('product_id', $pid)->first();

        if (!$cart) {
            return ResponseUtil::errorJsonResponse('product on cart not found', 400);
        }

        $cart->delete();

        return ResponseUtil::successJsonResponse($pid);
    }
}
