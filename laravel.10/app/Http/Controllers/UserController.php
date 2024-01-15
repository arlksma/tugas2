<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        // Return json Response
        return response()->json([
            'results' => $users
        ],200);
    }
     public function store(UserStoreRequest $request)
     {
       try {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);
        return response()->json([
            'message' => "User seccessfully created."
        ],200);


       } catch(\Exception $e){
        return response()->json([
            'message'=>"something went really wrong!"
        ],500);
       }
     }


    public function show($id)
    {
        //user detail
        $users = User::find($id);
        if(!$users){
        return response()->json([
            'message' => 'User Not Found.'
        ],404);
    }
    return response()->json([
        'user' => $users
    ],200);

    }
    public function update(Request $request, $id)
    {
     try { 
        $users = User::find($id);
        if(!$users){
        return response()->json([
            'message' => 'User Not Found.'
        ],404);
    }
    $users->name = $request->name;
    $users->email = $request->email;
    $users->password = $request->password;

    $users->save();

    \Log::info('data di terima:', $request->all());
        return response()->json([
        'message' => 'User successfully updated.'
    ],200);

    } catch(\Exception $e){
        return response()->json([
            'message'=>"something went really wrong!",
            "message" => $e->getMessage(),
        ],500);
       }
    }
    public function delete($id)
    {
        $users = User::find($id);
        if(!$users){
        return response()->json([
            'message' => 'User Not Found.'
        ],404); 
    }
    $users->delete();

    return response()->json([
        'message' => 'User successfully deleted.'
    ],200); 
}

}
