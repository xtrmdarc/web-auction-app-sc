<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function login(Request $request) 
    {
        $user = User::where('username', $request['username'])->first();
        if($user)
            return response()->json($user, 200);
        else 
        {
            return response()->json(['message' => 'User not found', 'code' => 406], 406);
        }
    }

    public function update(Request $request)
    {
        $user = User::find($request['id']);
        $update = $user->update($request);
        if($update)
            return response()->json($user, 200);
        else 
        {
            return response()->json(['message' => "We couldn't update the user", 'code' => 406], 406);
        }
    }
}
