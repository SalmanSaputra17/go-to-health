<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Requests\Api\Auth\LoginRequest;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
    	\DB::beginTransaction();

    	try {
    		$user = User::create([
    			'unique_id' => User::generateUID(),
    			'username' => $request->username,
    			'gender' => $request->gender,
    			'date_of_birth' => $request->date_of_birth,
    			'email' => $request->email,
    			'password' => Hash::make($request->password),
    		]);

    		\DB::commit();

    		return response()->json([
    			'status' => 'SUCCESS',
    			'message' => 'Successfully created new user.' 
    		], 201);
    	} catch(\Exception $e) {
    		\DB::rollback();

    		return response()->json([
    			'status' => 'FAILED',
    			'message' => 'error: ' . $e->getMessage(),
    		], 500);
    	}
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);

            if (!Auth::guard('driver-api')->attempt($credentials))
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'Unauthorized.'
                ], 401);

            $user = Auth::guard('driver-api')->user();

            $tokenResult = $user->createToken('GoToHealth');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
            ]);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'FAILED',
                'message' => 'error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
    	$request->user()->token()->revoke();

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Successfully logout.'
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());    	
    }
}
