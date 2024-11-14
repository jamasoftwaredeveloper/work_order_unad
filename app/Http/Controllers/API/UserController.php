<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $inputs = $request->only(['email', 'password']);;

        if (!Auth::attempt($inputs)) {
            return Response(
                [
                    'status' => 401,
                    'message' => 'Unauthorized',
                    'data' => null
                ],
                401
            );
        }

        $user = Auth::user();

        $token = $user->createToken('AppZoom')->accessToken;

        return Response(
            [
                'status' => 200,
                'message' => 'Ok',
                'data' => $token
            ],
            200
        );
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (Auth::user()) {
            $request->user()->token()->revoke();

            return Response(
                [
                    'status' => 200,
                    'message' => 'Logged out successfully',
                    'data' => null
                ],
                200
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        if (Auth::guard('api')->check()) {
            $user = Auth::guard('api')->user();
            return Response(
                [
                    'status' => 200,
                    'message' => 'Ok',
                    'data' => $user
                ],
                200
            );
        }

        return Response(
            [
                'status' => 401,
                'message' => 'Unauthorized',
                'data' => null
            ],
            401
        );
    }
}
