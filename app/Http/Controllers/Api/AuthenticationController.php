<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use App\Http\Requests\RegistrationPostRequest;
use App\Http\Resources\Userresource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    use ApiResponse;

    public function login(LoginPostRequest $request)
    {

        $validatedData = $request->validated();

        if (!Auth::attempt($validatedData)) {
            return $this->error(401, [], 'Unauthorized');
        }

        $user = User::all()->where('email', '=', $validatedData['email'])->first();

        if (!Hash::check($validatedData['password'], $user->password, [])) {
            throw new \Exception('Error in Login');
        }

        return $this->success([
            'token' => $user->createToken($user->id)->plainTextToken,
            'user' => Userresource::make($user),
        ], 'user successfully logged in', 201);

    }

    public function registration(RegistrationPostRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
        $token = $user->createToken($user->id)->plainTextToken;

        return $this->success(['user' => Userresource::make($user), 'token' => $token], 'user successfully created', 201);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return $this->success([], 'Token successfully deleted',);
    }
}
