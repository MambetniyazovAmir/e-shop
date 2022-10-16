<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return UserResource::collection($users);
    }

    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $response = [
            'user' => UserResource::make($user),
            'token' => $user->createToken('admin')->plainTextToken,
        ];
        return response($response, 201);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Wrong email or password'
            ], 401);
        }

        $response = [
            'user' => UserResource::make($user),
            'token' => $user->createToken('admin')->plainTextToken,
        ];
        return response($response, 201);
    }

    public function logout()
    {
        auth('sanctum')->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }

    public function update(Request $request, User $user)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|exists:users,email',
            'password' => 'required|string|confirmed'
        ]);
        $user->update([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);
        return UserResource::make($user);
    }

    public function delete(User $user)
    {
        if ($user->delete()) {
            return response(['message' => "Deleted successfully"]);
        }
    }
}
