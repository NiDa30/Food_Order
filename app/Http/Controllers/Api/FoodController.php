<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    //Chỉ lấy những món còn hàng
    public function index()
    {
        $foodItems = Food::where('is_available', true)->get();
        return respond()->json($foodItems);
    }

    //Lấy thông tin chi tiết món ăn
    public function show(Food $food)
    {
        return respond()->json($food);
    }

    //Thêm món ăn mới - Admin
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'is_available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return respond()->json(['errors' => $validator->errors()], 422);
        }

        $food = Food::create($request->all());
        return respond()->json(['message' => 'Tạo thức ăn thành công', 'food' => $food], 201);
    }

    //Sửa món ăn
    public function update(Request $request, Food $food)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'image' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'is_available' => 'boolean',
        ]);

        if ($validator->fails()) {
            return respond()->json(['errors' => $validator->errors()], 422);
        }

        $food->update($request->all());
        return respond()->json(['message' => 'Cập nhật thức ăn thành công', 'food' => $food]);
    }

    //Xóa món ăn
    public function destroy(Food $food)
    {
        $food->delete();
        return respond()->json(['message' => 'Xóa món ăn thành công']);
    }
}
