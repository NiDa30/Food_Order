<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Food;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{    public function index()
    {
        $users = User::all();
        $foods = Food::all();
        return view('admin.dashboard', compact('users', 'foods'));
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getFoods()
    {
        $foods = Food::all();
        return response()->json($foods);
    }

    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'is_admin' => 'boolean'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'is_admin' => $validated['is_admin'] ?? false
        ]);

        return response()->json($user, 201);
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'is_admin' => 'boolean'
        ]);

        $user->update($validated);
        return response()->json($user);
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function createFood(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string'
        ]);

        $food = Food::create($validated);
        return response()->json($food, 201);
    }

    public function updateFood(Request $request, Food $food)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'required|string'
        ]);

        $food->update($validated);
        return response()->json($food);
    }

    public function deleteFood(Food $food)
    {
        $food->delete();
        return response()->json(['message' => 'Food deleted successfully']);
    }
}
