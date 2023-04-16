<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('authToken')->accessToken;

            DB::commit();
            return response()->json(['success'=>true,'token' => $token], 200);
        }catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
