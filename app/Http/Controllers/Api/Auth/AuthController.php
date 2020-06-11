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
use App\Notifications\RegisterActivate;

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
                'activation_token' => \Str::random(60),
    		]);

            $user->notify(new RegisterActivate($user));

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

    public function activate($token)
    {
        $user = User::whereActivationToken($token)->first();

        if (!$user)
             return response()->json([
                'status' => 'FAILED',
                'message' => 'This activation token is invalid.'
            ], 404);

        $user->update([
            'active' => true,
            'activation_token' => null
        ]);

        return $user;
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = request(['email', 'password']);
            $credentials['active'] = 1;
            $credentials['deleted_at'] = null;

            if (!Auth::guard('driver-api')->attempt($credentials))
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'Unauthorized.'
                ], 401);

            $user = Auth::guard('driver-api')->user();

            $tokenResult = $user->createToken('GoToHealth');
            $token = $tokenResult->token;

            $token->expires_at = $request->remember_me ? Carbon::now()->addYears(1) : Carbon::now()->addHour();
            $token->save();

            return response()->json([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString(),
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

    public function currentUser(Request $request)
    {
        return response()->json($request->user());    	
    }
}
