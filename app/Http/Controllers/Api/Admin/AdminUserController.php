<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    //Lấy danh sách tất cả người dùng (không bao gồm admin)
    public function index(Reques $request)
    {
        $users = User::all();
        return respond()->json($users);
    }

    //Xem chi tiết một người dùng cụ thể
    public function show(User $user)
    {
        return respond()->json($user);
    }

    //Xóa người dùng
    public function destroy(Request $request, User $user)
    {
        if ($user->id === $request->user()->id) {
            return respond()->json(['message' => 'Không thể xóa chính tài khoản của bạn'], 403);
        }

        $user->delete();
        return respond()->json(['message' => 'Xóa tài khoản thành công']);
    }
}
