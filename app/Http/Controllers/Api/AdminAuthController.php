<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class AdminAuthController extends BaseController
{
    public function adminregister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'nullable',
            'status' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->all()
            ], 422); 
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  
            'role' => $request->role,       
            'status' => $request->status,   
        ]);

        return $this->sendResponse($user,'User created successfully');
    }
    public function adminlogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation failed.',$validator->errors()->all(),422);
        }

        if (Auth::attempt(['email' => $request->email,'password' => $request->password])) {
            $Authuser = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'Authentication successful.',
                'token' => $Authuser->createToken("API Token")->plainTextToken,
                'token_type' => 'bearer'
            ], 200); 
        } else {
            return $this->sendError('The provided credentials are incorrect.',401);
        }
    }

    public function adminlogout(Request $request)
    {
        $admin = $request->user();
        $admin->tokens()->delete(); 
        return $this->sendResponse($admin,'logout successfully.');
    }
}
