<?php

namespace App\Http\Controllers;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ChangePasswordController extends Controller
{
    public function index(Request $request)
    {
        return view('change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ], [
            'password.required' => 'Please enter a password',
            'password.min'      => 'Password must be at least 6 characters',
        ]);
        
        $password  = $request->password;
        $userId = Auth::id();
        $updatePassword = AdminUser::where('id', $userId)->update([
            'password' => Hash::make($password),
            'sample_pass' => $password
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Password updated successfully',
        ], 200);

    }
}
