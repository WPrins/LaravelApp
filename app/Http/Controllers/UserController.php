<?php
namespace App\Http\Controllers;

use App\user;
use App\Chatkit;
use illuminate\Http\Request;

class UserController extends Controller 
{
    public function create(Request $request, Chatkit $chatkit)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $data['chatkit_id'] = str_slug($data['email'], '_');

        $response = $chatkit->createUser([
            'id' => $data['chatkit_id'],
            'name' => $data['name']
        ]);

        if ($response['status'] !== 201) {
            return response()->json(['status' => 'error'], 400);
        }

        return response()->json(User::create($data));
    }
}
