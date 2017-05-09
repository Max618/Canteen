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
	    	$name = $request->only('name');
	    	$email = $request->only('email');
	    	$turma = $request->only('turma');
	    	$nivel = 5;
	    	//Procura responsavel no bd
	    	$resp = App\User::find($id);
	    	//cria o filho em Users
	    	$filho = App\User::create([
	    			'name' => $name,
	    			'email' => $email,
	    			'nivel' => $nivel,
	    		]);
	    	//cria o filho em Alunos
	    	$aluno = new App\Aluno();
	    	$aluno->user_id = $filho->id;
	    	$aluno->turma = $turma;
	    	$aluno->save();
	    	//cria relacionamento
	    	$relacionamento = App\Relacionamento::create([
	    			'aluno_id' => $filho->id,
	    			'user_id' => $id,
	    		]);
	    	return response()->json(['sucesso' => 'Aluno cadastrado com sucesso']);
	    }
	    catch (\Exeption $e)
	    {
	    	return $e;
	    }
    }
}
