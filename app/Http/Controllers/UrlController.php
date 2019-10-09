<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Url;
use Illuminate\Http\Request;

class UrlController extends Controller
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
                'url' => 'required',
            ]);

            $shortCode = $this->generateUniqueCode();

            $url = Url::create([
                'url_original' => $request->url,
                'url_short' => env('APP_SHORTDOMAIN').$shortCode,
                'short_code' => $shortCode,
                'user_id' => Auth::user()->id,
                'stats' => '{clicks: 0}',
            ]);
            
            $data = [
                "original" => $url->url_original,
                'short' => $url->url_short
            ];

            return response()->json(['success' => true, 'msg' => 'Url encurtada com sucesso',  'data' => $data]);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    /**
     * Retorna todas as urls do usuário
     *
     * @param  int  $id
     * @return Response
     */
    public function show(Request $request)
    {
        try {
            $url = Url::where('url_short', '=', $request->url)->first();

            if (!$url) {
                return response()->json(["error" => true, "message" => "Url não encontrada"]);
            }
            
            $info = [
                "original" => $url->url_original,
                "short" => $url->url_short,
                "created_at" => $url->created_at,
                "stats" => $url->stats
            ];

            return response()->json(['urls' => $info]);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    /**
     * Retorna todas as urls do usuário
     *
     * @param  int  $id
     * @return Response
     */
    public function showUser($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(["error" => true, "message" => "Usuário não encontrado"]);
            }

            return response()->json(['urls' => $user->urls]);
        } catch (\Exception $exception) {
            return response()->json(["error" => true, "message" => $exception->getMessage()]);
        }
    }

    /**
     * Cria um código único para a url
     */
    public function generateUniqueCode()
    {
        $token = substr(md5(uniqid(rand(), true)),0,7); // cria um codigo de 7 caracteres
        $url = Url::where('short_code', '=', $token)->first();
        
        // Verifica se já existe o código
        if ($url) {
            // Se exitir o código, chama novamente a função
            $this->generateUniqueCode();
        } else {
            return $token;
        }
    }
}