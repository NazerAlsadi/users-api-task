<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $isApi = $request->is('api/*') || $request->wantsJson();

        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/'
            ]
        ]);

        if ($validator->fails()) {
            return $isApi
                ? response()->json($validator->errors(), 422)
                : redirect()->back()->withErrors($validator)->withInput();
        }

        // Create user
        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign default role
        $role = Role::where('name', 'user')->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }

        // API REGISTER
        if ($isApi) {
            $token = auth('api')->login($user);
            $user->token = $token;
            $user->save();
            return response()->json([
                'message' => 'User registered successfully',
                'user' => $user,
                'roles' => $user->roles,
                'token' => $token
            ]);
        }

        // WEB REGISTER WITH SESSION 
        auth()->login($user);

        return redirect()
            ->route('dashboard')
            ->with('success', 'Account created successfully!');
    }


    // Login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $isApi = $request->is('api/*') || $request->wantsJson();

        // API LOGIN
        if ($isApi) {
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
            //SAVE TOKEN TO DB IF WANT
            $user = auth('api')->user();
            $user->token = $token;
            $user->save();

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => auth('api')->user()
            ]);
        }

        // WEB LOGIN
        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard')
                ->with('success', 'Logged in successfully');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Invalid login credentials']);
    }


    // Logout API
    public function logout(Request $request)
    {
        if ($request->wantsJson()) {
            auth('api')->logout();
            return response()->json(['message' => 'Logged out']);
        }

        auth()->logout();
        return redirect()->route('login')->with('success', 'Logged out');
    }


    // API: get authenticated user
    public function me()
    {
        return response()->json(auth('api')->user());
    }
}
