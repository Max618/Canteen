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