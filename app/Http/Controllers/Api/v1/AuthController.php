<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
                return self::error(config('response.validation_error'), $validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $token = $user->createToken('authToken')->accessToken;

            DB::commit();
            return self::success(config('response.register_success'), ['token'=>$token], null, Response::HTTP_CREATED);
        }catch (\Throwable $e) {
            DB::rollBack();
            throw new \HttpResponseException(self::error(config('response.internal_server_error'), $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR));
        }

    }
}
