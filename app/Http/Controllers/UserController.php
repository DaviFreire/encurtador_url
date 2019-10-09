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
        try {
            $this->validate($request, [
                'email' => 'required|email|unique:users',
                'password' => 'required'
            ]);

            $hasher = app()->make('hash');

            $user = User::create([
                'email' => $request->email,
                'password' => $hasher->make($request->password)
            ]);

            return response()->json(['success' => true, 'msg' => 'Usuário registrado com sucesso',  'data' => $user]);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    /**
     * Atualiza um usuário
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        try {
            $this->validate($request, [
                'password' => 'required'
            ]);

            $user = User::find($id);

            if(!$user) {
                return response()->json(["error" => true, "message" => "Usuário não encontrado"]);
            }

            $hasher = app()->make('hash');

            $user->update([
                'password' => $hasher->make($request->password)
            ]);

            return response()->json(['success' => true, 'msg' => 'Usuário atualizado com sucesso', 'data' => $user]);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    /**
     * Excluir usuário
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {   
        try {
            if (Url::where('user_id',$id)->first()) {
                return response()->json(["error" => true, "message" => "Usuáio não excluído, pois existe URL associada ao mesmo"]);
            }
            User::find($id)->delete();
            return response()->json(['success' => true, 'msg' => 'Usuário excluido com sucesso']);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }
}