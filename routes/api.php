<?php

Auth::routes();

Route::post('/login', 'auth\LoginController@login');
Route::post('/register', 'auth\RegisterController@register');
/*Route::post('/register', function (Request $request) {
    fopen("test.txt", "w");
});*/

Route::group(['prefix' => 'cantina'], function () {
    Route::put('produtos', 'ProdutosController@store')->name('produto.store');
    Route::put('produtos/{id}', 'ProdutosController@update')->name('produto.update');
    Route::post('produtos/{id}/delete', 'ProdutosController@destroy')->name('produto.destroy');
    Route::post('pedidos', 'PedidosController@show')->name('pedido.show');
    Route::post('produtos/all', 'ProdutosController@getAll')->name('pedido.all');
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
});