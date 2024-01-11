<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        // attempt a login (validate the credentials provided)
        $token = auth()->guard('api')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // if token successfully generated then display success response
        // if attempt failed then "unauthenticated" will be returned automatically
        if ($token) {
            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User fetched successfully.',
                ],
                'data' => [
                    'user' => auth()->guard('api')->user(),
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                    ],
                ],
            ]);
        } else {
            return response()->json([
                'meta' => [
                    'code' => 404,
                    'status' => 'failed',
                    'message' => 'User not found.',
                ],
            ]);
        }
    }

    public function register(Request $request)
    {
        $isEmailUnique = User::where('email', $request->email)->get()->isEmpty();
        if ($isEmailUnique) {
            $otp = random_otp();
            $content = [
                'otp' => $otp,
            ];
            $now = Carbon::now()->setTimezone('Asia/Jakarta');

            $user = User::create([
                'email' => $request->email,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'password' => $request->password,
                'role' => 'member',
            ]);

            $otpSave = Otp::create([
                'user_id' => $user->id,
                'type' => 'Registration',
                'otp' => Hash::make($otp),
                'expired_at' => $now->addMinutes(5),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $otpSend = Mail::to($request->email)->send(new OtpMail($content));
            if ($otpSave && $otpSend) {
                return response()->json([
                    'meta' => [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'User created and OTP send successfully.',
                    ],
                ]);
            }

            return Response::json([
                'meta' => [
                    'code' => 400,
                    'status' => 'failed',
                    'message' => 'User created but OTP not send.',
                ],
            ], 400);
        }

        return Response::json([
            'meta' => [
                'code' => 400,
                'status' => 'failed',
                'message' => 'Failed to create user.',
            ],
        ], 400);
    }

    public function registerOtpCheck(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            $otp = Otp::where('user_id', $user->id)->where('type', 'Registration')->latest()->first();
            $now = Carbon::now()->setTimezone('Asia/Jakarta');
            if ($otp->expired_at > $now) {
                if (Hash::check($request->otp, $otp->otp)) {
                    User::where('email', $request->email)->update([
                        'email_verified_at' => $now,
                    ]);
                    $otp->delete();

                    return Response::json([
                        'meta' => [
                            'code' => 202,
                            'status' => 'success',
                            'message' => 'OTP is valid.',
                        ],
                    ], 202);
                }

                return Response::json([
                    'meta' => [
                        'code' => 401,
                        'status' => 'failed',
                        'message' => 'OTP is not valid.',
                    ],
                ], 401);
            }

            return Response::json([
                'meta' => [
                    'code' => 403,
                    'status' => 'failed',
                    'message' => 'OTP code has expired.',
                ],
            ], 403);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 400,
                    'status' => 'failed',
                    'message' => 'Bad request.',
                ],
            ], 400);
        }
    }

    public function registerOtpResend(Request $request)
    {
        try {
            $newOtp = random_otp();
            $user = User::where('email', $request->email)->first();
            $otp = Otp::where('user_id', $user->id)->where('type', 'Registration')->latest()->first();
            $now = Carbon::now()->setTimezone('Asia/Jakarta');
            $otp->update([
                'otp' => Hash::make($newOtp),
                'expired_at' => $now->addMinutes(5),
            ]);
            Mail::to($request->email)->send(new OtpMail(['otp' => $newOtp]));

            return Response::json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'OTP code has been send.',
                ],
            ], 200);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 400,
                    'status' => 'failed',
                    'message' => 'Bad request.',
                ],
            ], 400);
        }
    }

    public function logout()
    {
        auth()->guard('api')->logout();

        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'User logout successfully.',
            ],
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'user' => Auth::guard('api')->user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

    public function userProfile()
    {
        return response()->json(auth()->guard('api')->user());
    }
}

function random_otp($length = 4)
{
    return rand(pow(10, $length - 1), pow(10, $length) - 1);
}
