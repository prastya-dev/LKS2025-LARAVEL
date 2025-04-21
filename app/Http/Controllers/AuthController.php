<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Administrators;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $req){
        $req->validate([
            'username' => 'required|min:4|max:50',
            'password' => 'required|min:8|max:18'
        ]);
        $user = Users::where('username', $req->username)->first();
        $admin = Administrators::where('username', $req->username)->first();
        if($user && Hash::check($req->password, $user->password)){
            return $user->createToken('username')->plainTextToken;
        }
        else if($admin && Hash::check($req->password, $admin->password)){
             return $admin->createToken('username')->plainTextToken;
        }
 

        return response()->json([ "message" => 'Username Or Password Incorrect'],401);
    }
    public function signup(Request $request){
        $request->validate([
            'username' => 'required|unique:Users,username|min:5|max:50',
            'password' => 'required|min:8|max:18'
        ]);
        $pass = Hash::make($request->password);
        $user = Users::create([
            'username' => $request->username,
            'password' => $pass, 
        ]);
        return response()->json(['Success created user' => $user->username], 200);
    }

    public function signout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return response()->json(['Success SignOut'],200);
    }

}
