<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Administrators;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UsersResource;


class UsersController extends Controller
{
    public function getUser(Request $request){
        $user = $request->user()->username;
        $admin = Administrators::where('username',$user)->first();
        $users = Users::where('username',$user)->first();

        if($admin){
            return response()->json(["data" => $admin,"role" => "admin"],200);
        }
        return response()->json(["data" => new UsersResource($users),"role" => "user"],200);
    
        
        
    }
    public function users(){
        $user = UsersResource::collection(Users::all());
        return response()->json(["message" => "Get All User Success", "TotalData" => Users::count(), "data" => $user]);
    }
    public function admins(){
        $user = UsersResource::collection(Administrators::all());
        return response()->json(["message" => "Get All Administrators Success", "TotalData" => Administrators::count(), "data" => $user]);
    }

    public function getUsername($username){
        $user = Users::where('username',$username)->first();
        if(!$user){
            return response()->json(['Not Found'],404);
        }
       return  response()->json([$user],200);
    }

    public function update(Request $request,$id){
       $user = Users::find($id);
       if(!$user){
        return response()->json(["User Not Found"],404);
       }
        $request->validate([
            'username' => 'min:4|max:50|unique:users,username',
            'password' => 'min:8|max:15'
        ]);
        
        if($request->filled('username')){
            $user->username = $request->username;
        }
        if($request->filled('password')){
            $user->password =  Hash::make($request->password);
        }
        
        
        $user->save();
        return response()->json(["success update " => $user],200);
        }
        public function delete($id){
            $user = Users::find($id);
            if(!$user){
                return response()->json(["User Not Found"],404);
             }
             $user->delete();
             return response()->json(["success delete users:" => $user->username]);
        }
}
