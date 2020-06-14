<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Auth\PasswordResetRequest as PRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{
    public function request(Request $request)
    {
		try {
            $request->validate([
                'email' => 'required|string|email'
            ]);

            $user = User::whereEmail($request->email)->first();

            if (!$user)
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'We can\'t find a user with that e-mail address.'
                ], 404);

            $passwordReset = PasswordReset::updateOrCreate([
                'email' => $request->email,
            ], [
                'email' => $request->email,
                'token' => \Str::random(60),
            ]);

            if ($user && $passwordReset)
                $user->notify(new PasswordResetRequest($passwordReset->token));

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'We have emailed your password reset link.'
            ], 201);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'FAILED',
                'message' => $e->getMessage(),
            ], 200);
        }
    }

    public function find($token)
    {
    	try {
            $passwordReset = PasswordReset::whereToken($token)->first();        

            if (!$passwordReset)
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'This password reset token is invalid.'
                ], 404);        

            if (Carbon::parse($passwordReset->updated_at)->addMinutes(720)->isPast()) {
                $passwordReset->delete();

                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'This password reset token is invalid.'
                ], 404);
            }

            return response()->json($passwordReset, 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function reset(PRequest $request)
    {
        try {
            $passwordReset = PasswordReset::where([
                ['token', $request->token],
                ['email', $request->email]
            ])->first();

            if (!$passwordReset)
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'This password reset token is invalid.'
                ], 404);

            $user = User::whereEmail($passwordReset->email)->first();

            if (!$user)
                return response()->json([
                    'status' => 'FAILED',
                    'message' => 'We can\'t find a user with that e-mail address.'
                ], 404);

            $user->password = Hash::make($request->password);
            $user->save();

            $passwordReset->delete();
            $user->notify(new PasswordResetSuccess($passwordReset));

            return response()->json([
                'status' => 'SUCCESS',
                'message' => 'Success change your password.'
            ], 200);
        } catch(\Exception $e) {
            return response()->json([
                'status' => 'FAILED',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
