<?php

namespace App\Http\Controllers\Api;

use App\Models\Staff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StaffLoginController extends Controller
{






    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = Staff::where('email', $request->post('email'))->first();
        if($user && Hash::check($request->post('password'), $user->password)){



            $token = $user->createToken($request->header('user-agent'));
        }

        return[
            'token' => $token->plainTextToken,
            'status' => 200
        ];
    }




    public function logout()
    {
        $user = Auth::guard('sanctum')->user();
        $user->currentAccessToken()->delete();

        return[
            'message' => 'token deleted'
        ];
    }
}
