<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseUtil;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $user = auth()->user();

        return ResponseUtil::successJsonResponse($user->orders);
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

        $validator = $this->validateOrderRequest($request);
        if ($validator->fails()) {
            return ResponseUtil::errorJsonResponse($validator->errors(), 400);
        }

        $order = $user->orders()->where('uuid', $request->get('uuid'))->first();
        if ($order) {
            return ResponseUtil::errorJsonResponse('order already exist', 400);
        }

        $billing = $user->billings()->where('address', $request->get('address'))
            ->where('country', $request->get('country'))
            ->where('city', $request->get('city'))
            ->where('postcode', $request->get('postcode'))
            ->first();

        if (!$billing) {
            $billing = $user->billings()->create([
                'address' => $request->get('address'),
                'country' => $request->get('country'),
                'city' => $request->get('city'),
                'postcode' => $request->get('postcode')
            ]);
        }

        $order = $user->orders()->create([
            'uuid' => $request->get('uuid'),
            'billing_id' => $billing->id,
            'total_price' => doubleval($request->get('totalPrice')),
            'status' => $request->get('status')
        ]);

        return ResponseUtil::successJsonResponse($order, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return JsonResponse
     */
    public function show($uuid)
    {
        $user = auth()->user();

        $order = $user->orders()->where('uuid', $uuid)->first();

        if (!$order) {
            return ResponseUtil::errorJsonResponse('order does not exist', 400);
        }

        return ResponseUtil::successJsonResponse($order);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateOrderRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'totalPrice' => 'required|numeric',
            'status' => 'required|numeric',
            'uuid' => 'required|string',
            'address' => 'required|string',
            'country' => 'nullable|string',
            'city' => 'nullable|string',
            'postcode' => 'nullable|string'
        ]);
    }
}
