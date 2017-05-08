<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produto;
use Illuminate\Pagination\Paginator;

class ProdutosController extends CantinaController
{
    public function __construct()
    {
        //$this->middleware('cantina')->except('show','showLunch');
    }

    public function store(Request $request)
    {
        try {
            $produto = new Produto();
            $produto->fill($request->only('name','amount','price','type'));
            $produto->save();

            return response()->json(['success' => 'Produto inserido com Sucesso!']);
        }
        catch (\Exception $e){
            return $e;
        }
    }

    public function update(Request $request, $id)
    {
        try
        {
            $produto = Produto::find($id);
            $produto->fill($request->only('name', 'amount', 'price', 'type'));
            $produto->save();
            return response()->json(['success' => 'Produto salvo com sucesso!']);
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

    public function destroy($id)
    {
        try{
            $produto = Produto::find($id);
            $produto->type += 50;
            $produto->save();
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

    public function show(){
        $lanches = Produto::select('id','name','price')->where('type', 1)->where('amount', '>', 0)->get();
        $outros = Produto::select('id','name','price')->where('type', 3)->where('amount', '>', 0)->get();
        $retorno = [
            'lanches' => $lanches,
            'outros' => $outros,
        ];
        return response()->json($retorno);
    }

    public function showLunch(){
        $produtos = Produto::select('id','name','price')->where('type', 2)->get();
        return response()->json($produtos);
    }

    public function getAll()
    {
        try{
        $produtos = Produto::where('type','not like', '5%')->get();
        return response()->json($produtos);
        }
        catch(\Exception $e)
        {
            return $e;
        }
    }
}
