<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Cria um usuário
     *
     * @param  int  $id
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        $hasher = app()->make('hash');

        $user = User::create([
            'email' => $request->email,
            'password' => $hasher->make($request->password)
        ]);

        response()->json(['success' => true, 'data' => $user]);
    }
}