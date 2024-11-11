<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\AccountManagement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkoutUserActive(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'account' => ['required'],
                'password' => ['required'],
            ]);

            if ($validator->fails()) {
                return Response(
                    [
                        'status' => 403,
                        'message' => 'Forbidden',
                        'data' =>  $validator->errors()->messages()
                    ],
                    403
                );
            }

            $account = AccountManagement::select('status', 'id')->where('account', $request->account)->where('password', $request->password)->where('status', 1)->first();
            $accountUpdate = AccountManagement::find($account->id);
            if (!$account) {
                return Response(
                    [
                        'status' => 401,
                        'message' => 'Unauthorized',
                        'data' =>  false
                    ],
                    401
                );
            }
            if ($accountUpdate->days_remaining_credit === 0) {
                $accountUpdate->final_expiration_date = null;
                $accountUpdate->status = 0;
                $accountUpdate->initial_creation_date = null;
                $accountUpdate->expired = 'expired';
                $accountUpdate->in_used = 'not_used';
                $accountUpdate->save();
                return Response(
                    [
                        'status' => 401,
                        'message' => 'Unauthorized',
                        'data' =>  false
                    ],
                    401
                );
            }
            if ($accountUpdate->final_expiration_date === null) {
                $dateCurrent = Carbon::now();
                $accountUpdate->final_expiration_date = $dateCurrent->addDays(30);
            }
            if ($accountUpdate->initial_creation_date === null) {
                $accountUpdate->initial_creation_date = Carbon::now();
            }
            if ($accountUpdate->control_income_date === null) {
                $accountUpdate->control_income_date = Carbon::now();
                $accountUpdate->days_remaining_credits = $accountUpdate->days_remaining_credits - 1;
            }
            $dateCurrentIncome = Carbon::now();
            if ($accountUpdate->control_income_date !== null) {
                $dateCurrentIncomeNotNull = Carbon::parse($accountUpdate->control_income_date);
                if ($dateCurrentIncome->diffInDays($dateCurrentIncomeNotNull) === 1) {
                    $accountUpdate->control_income_date = Carbon::now();
                    $accountUpdate->days_remaining_credits = $accountUpdate->days_remaining_credits - 1;
                }
            }

            if ($accountUpdate->in_used === 'not_used') {
                $accountUpdate->in_used = 'used';
            }
            $accountUpdate->save();
            DB::commit();
            return Response(
                [
                    'status' => 200,
                    'message' => 'Authorized',
                    'data' =>  true
                ],
                200
            );
        } catch (\Exception $ex) {
            DB::rollback();
            return Response(
                [
                    'status' => 500,
                    'message' => 'Error' .  $ex->getMessage() . ' Linea ' . $ex->getFile(),
                    'data' =>  false
                ],
                200
            );
        }
    }
}
