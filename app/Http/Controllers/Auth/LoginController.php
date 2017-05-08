<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $email = $request->only('email');
        try {
            // verifica credenciais do usuario
            
            if (! $token = Auth::attempt($credentials)) {
                return response()->json(['nivel' => 0]);
            }
        } catch (Exception $e) {
            // credenciais erradas
            return response()->json(['erro' => 'could_not_create_token'], 401);
        }
        // td ok, pega nivel do usuario e retorna
        $user = App\User::where('email', $email)->first();
        $nivel = $user->nivel;
        session(['nivel' => $nivel]);
        session(['user' => $user]);
        if($nivel == 2)
        {
            $filhos = $this->pegarFilhos($user);
            $array = new \ArrayObject();
            foreach ($filhos as $filho) {
                //dd($filho->user['name']);
                $array->append([
                'id' => $filho->id,
                'nome' => $filho->user['name'],
                'turma' => $filho->turma,
                ]);
            }
            return response()->json(['nivel' => $nivel,'user' => $user->id, 'filhos' => $array]);
        }
        return response()->json(['nivel' => $nivel,'user' => $user]);
    }

    private function pegarFilhos(App\User $user)
    {
        return $user->filhos;
    }
}
