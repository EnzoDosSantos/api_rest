<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use \stdClass;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request -> all(), [
            'email' => 'required|email|max:40|unique:users'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

        $user = User::create([
            'email' => $request->email
        ]);

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json(['acces_token' => $token]);
    }

    public function login(Request $request){
        $user = User::where('email', $request['email']) -> first();

        if(!$user){
            return response()->json(['Message' => 'Invalid credentials'], 401);
        }


        // FIXME: Aqui podriamos usar un DTO y asi mantener las responses lo mas seguras posibles, aqui seria en vano debido a que users es algo tan simple

        $userResponse = new stdClass();
        $userResponse->email = $user['email'];
        $token = $user->createToken('auth')->plainTextToken;

        return response()->json(['user' => $userResponse, 'acces_token' => $token]);
    }
}
