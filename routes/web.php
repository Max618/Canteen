<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//Route::any('/filho/criar/{id}', 'ResponsavelController@createFilho');

Route::get('teste/{id}', function ($id) {
	$user = App\User::find($id);
	$filhos = $user->filhos;
	//dd($filhos);
	//dd($filhos);
	$array = new \ArrayObject();
            foreach ($filhos as $filho) {
                //dd($filho->user['name']);
                $array->append([
                'id' => $filho->user['id'],
                'nome' => $filho->user['name'],
                'turma' => $filho->turma,
                ]);
            }
    dd($array);
});

Route::get('teste2/{id}', function ($id) {
    $name = 'nome teste18';
    $email = 'teste email18';
    $turma = 'teste18';
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
    //Cria o filho em Alunos
    $aluno = new App\Aluno();
    $aluno->id = $filho->id;
    $aluno->turma = $turma;
    //salva o id do aluno
    $id_aluno = $aluno->id;
    //salva o aluno
    $aluno->save();
    //pega o aluuno pelo id
    $aluno = App\Aluno::find($id_aluno);
    //cria o relacionamento
    dd($resp->filhos()->attach($aluno->id));
});