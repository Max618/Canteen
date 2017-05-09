<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;

class ResponsavelController extends Controller
{
    public function getConfig($id){
        //pegar configurações do id e redireciona para show config
    }

    public function showConfig(){
        //pega configurações do get config e mostra
    }

    public function createFilho(Request $request, $id)
    {
    	try
    	{
	    	$name = $request->get('name');
	    	$email = $request->get('email');
	    	$turma = $request->get('turma');
	    	$nivel = 5;
	    	//Procura responsavel no bd
	    	$resp = App\User::find($id);
	    	//cria o filho em Users
	    	$filho = App\User::create([
	    	        'name' => $name,
	    	        'turma' => $turma,
	    	        'email' => $email,
	    	        'nivel' => $nivel,
	    	    ]);
	    	//cria o filho em Alunos
	    	$aluno = $resp->filhos()->create([
	    	        'turma' => $turma, 
	    	        'user_id' => $filho->id
	    	    ]);
	    	return response()->json(['sucesso' => 'Aluno cadastrado com sucesso']);
	    }
	    catch (\Exeption $e)
	    {
	    	return $e;
	    }
    }
}
