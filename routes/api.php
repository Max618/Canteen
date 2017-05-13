<?php
//use App;
use App\User;
use Illuminate\Http\Request;
Auth::routes();

Route::post('/login', function (Request $request) {
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
            $filhos = $user->filhos;
            $array = new \ArrayObject();
            foreach ($filhos as $filho) {
                //dd($filho->user['name']);
                $array->append([
                'id' => $filho->user['id'],
                'nome' => $filho->user['name'],
                'turma' => $filho->turma,
                ]);
            }
            return response()->json(['nivel' => $nivel,'user' => $user->id, 'filhos' => $array]);
        }
        return response()->json(['nivel' => $nivel,'user' => $user]);
});


Route::post('/register', function (Request $request) {
    $senha = $request->get('password');
        try{
            $novo = new User();
            $novo->fill($request->only('name','email'));
            $novo->password = bcrypt($senha);
            $novo->nivel = $request->get('nivel');
            $novo->save();
            return response()->json(['sucesso' => 'usuario criado com sucesso']);
        }
        catch(\Exception $e)
        {
            return $e;
        }
});

Route::group(['prefix' => 'cantina'], function () {
    Route::post('produtos/put', 'ProdutosController@store')->name('produto.store');
    Route::post('produtos/{id}/update', 'ProdutosController@update')->name('produto.update');
    Route::post('produtos/{id}/delete', 'ProdutosController@destroy')->name('produto.destroy');
    Route::post('pedidos/get', 'PedidosController@show')->name('pedido.show');
    Route::post('produtos/get', 'ProdutosController@getAll')->name('pedido.all');
    Route::post('pedidos/refeicoes', 'PedidosController@showLunch')->name('pedido.showLunch');
    //Route::post('pedido/create', 'PedidosController@create')->name('pedido.create');
});

Route::group(['prefix' => 'responsavel'], function () {
    Route::post('pedido/create', 'PedidosController@create')->name('pedido.create');
    Route::post('refeicao/create', 'PedidosController@createLunch')->name('lunch.create');
    Route::post('/', 'ResponsavelController@index')->name('responsavel.index');
    Route::post('/lanches', 'ProdutosController@show')->name('produto.show');
    Route::post('/refeicoes', 'ProdutosController@showLunch')->name('produto.showLunch');
    Route::post('/configuracoes/{id}', 'ResponsavelController@getConfig')->name('responsavel.getConfig');
    Route::post('/configuracoes', 'ResponsavelController@showConfig')->name('responsavel.showConfig');
    Route::post('/filho/criar/{id}', 'ResponsavelController@createFilho');
    Route::post('/{id}/filhos', 'ResponsavelController@getFilhos');
    Route::post('/filho/delete/{id}/{user_id}', 'ResponsavelController@deleteFilho');
    Route::post('/filho/edit/{id}', 'ResponsavelController@editFilho');

});