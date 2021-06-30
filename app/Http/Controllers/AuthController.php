<?php

namespace App\Http\Controllers;

use App\Http\Helpers\ResponseUtil;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request){
        $validator = $this->validateAuthRequest($request);
        if ($validator->fails()) {
            return ResponseUtil::errorJsonResponse($validator->errors(), 400);
        }

        $username = $request->get('username');
        $isEmail = (count(explode('@', $username)));
        $fieldKey = 'email';
        if ($isEmail == 1) {
            $fieldKey = 'username';
        }

        $user = User::where($fieldKey, '=', $username)->first();

        if (!$user) {
            return ResponseUtil::errorJsonResponse('Unauthorised', 401);
        }

        if (Auth::attempt([$fieldKey => $username, 'password' => $request->get('password')])) {
            $user = Auth::user();
            $success['access_token'] = $user->createToken('XenApp')->accessToken;
            return ResponseUtil::successJsonResponse($success);
        }

        return ResponseUtil::errorJsonResponse('Unauthorised', 401);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    private function validateAuthRequest(Request $request)
    {
        return Validator::make($request->all(), [
            'username' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout() {
        if (Auth::check()) {
            auth()->user()->token()->revoke();
        }
        return ResponseUtil::successJsonResponse('logged out successfully');
    }
}
