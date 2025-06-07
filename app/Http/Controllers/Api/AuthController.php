<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Đăng ký người dùng mới
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', 
        ]);

        if ($validator->fails()) {
            return respond()->json(['errors' => $validator->error()], 422); //Trả về lỗi validation 422
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_admin' => false, //Mặc định cho user thường
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return respond()->json([
            'message' => 'Đăng ký thành công',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ], 201);
    }

    //Đăng nhập người dùng
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return respond()->json(['errors' => $validator->errors()], 422);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return respond()->json(['message' => 'Sai thông tin đăng nhập'], 401);
        }

        //Lấy người dùng đã xác thực
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return respond()->json([
            'message' => 'Đăng nhập thành công',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    //Lấy thông tin người dùng hiện tại
    public function user(Request $request)
    {
        return respond()->json($request->user());
    }

    //Đăng xuất người dùng
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return respond()->json(['message' => 'Đăng xuất thành công']);
    }
}
