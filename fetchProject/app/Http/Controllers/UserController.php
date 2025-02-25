<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        if ($validator->passes()) {
            if (Auth::attempt($request->only('email', 'password'))) {
                return response()->json([
                    'result' => true,
                    'message' => 'Yes ...',
                    'user' => Auth::user()
                ]);
            } else {
                return response()->json([
                    'result' => false,
                    'message' => 'Invalid credentials'
                ]);
            }
        }
        return response()->json([
            'result' => false,
            'message' => 'No ...'
        ]);
    }

    public function logout(Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['result' => true, 'message' => 'Yes ...', 'csrf' => csrf_token()]);
    }

   public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users'],
            'password' => ['required', 'string'],
        ]);
        if ($validator->passes()) {
            $user = $this->create($request->all());
            Auth::login($user);
            return response()->json(['result' => true, 'message' => 'Yes ...']);
        }
        return response()->json(['result' => false, 'message' => 'No ...']);
    }

    private function create(array $data) {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}