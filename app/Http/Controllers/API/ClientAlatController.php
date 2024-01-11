<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Response;

class ClientAlatController extends Controller
{
    public function getMember()
    {
        try {
            $data = User::where('role', 'member')->get();

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'User fetched successfully.',
                ],
                'data' => $data,
            ]);
        } catch (\Throwable $th) {
            return Response::json([
                'meta' => [
                    'code' => 400,
                    'status' => 'failed',
                    'message' => 'Bad Requwst.',
                ],
            ], 400);
        }
    }
}
