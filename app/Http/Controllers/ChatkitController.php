<?php
namespace App\Http\Controllers;

use App\Chatkit;
use Illumate\Support\Facade\Auth;

class ChatkitController extends Controller 
{
    public function getToken(Chatkit $chatkit){
        $auth_data = $chatkit->authenticate([
            'user_id' => Auth::user()->chatkit_id
        ]);

        return  response()->json(
            $auth_data['body'],
            $auth_data['status']
        );
    }
}