<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Auth;

class PedidosController extends Controller
{
    public function __construct()
    {
        //$this->middleware('cantina')->except('create','createLunch');
    }
    
    public function show() {
        $pedidos  = App\Pedido::where('type', 0)->orderBy('delivery_date', 'desc')->get();
        $array = new \ArrayObject();
        foreach ($pedidos as $pedido){
            $tabelaAluno = App\Pedido::find($pedido['id'])->aluno;
               // echo "<br>".$tabelaAluno."<br>";
                $array->append([
                    'nome' => App\Aluno::find($tabelaAluno['user_id'])->user['name'],
                    'turma' => App\Pedido::find($pedido['id'])->aluno['turma'],
                    'pedidos' => $pedido['list'],
                    'preco_final' => $pedido['final_price'],
                    'delivery_date' => $pedido['delivery_date'],
                ]);
        }
        return response()->json($array);
    }

    public function showLunch() {
        $pedidos  = App\Pedido::where('type', 2)->orderBy('delivery_date', 'desc')->get();
        $array = new \ArrayObject();
        foreach ($pedidos as $pedido){
            $tabelaAluno = App\Pedido::find($pedido['id'])->aluno;
            // echo "<br>".$tabelaAluno."<br>";
            $array->append([
                'nome' => App\Aluno::find($tabelaAluno['user_id'])->user['name'],
                'turma' => App\Pedido::find($pedido['id'])->aluno['turma'],
                'pedidos' => $pedido['list'],
                'preco_final' => $pedido['final_price'],
                'delivery_date' => $pedido['delivery_date'],
            ]);
        }
        return response()->json($array);
    }

    public function create(Request $request)
    {
        //return $request->only('delivery_date');
        try 
        {
            $pedido = new App\Pedido();
            //$pedido->fill($request->only('final_price','aluno_id'));
            $pedido->fill($request->only('final_price','aluno_id','delivery_date'));
            $pedido->list = json_encode($request->only('list'));
            $pedido->user_id = implode('', $request->only('user'));
            $pedido->type = 0;
            //return $request->only('list');
            $lista = $request->only('list'); 
            if($pedido->save())
            {
                foreach ($lista as $produtoLista) {
                    foreach ($produtoLista as $produtoL) {
                        $produto = App\Produto::find($produtoL['id']);
                        $produto->amount-=$produtoL['qtde'];
                        $produto->save();
                    }
                }
                return response()->json(['sucesso' => 'Pedido realizado']);
            }
            return response()->json(['erro' => 'Erro ao enviar os dados']);
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }

    public function createLunch(Request $request)
    {
    	return $request;
        try {
            $pedido = new App\Pedido;
            $pedido->fill($request->only('final_price','aluno_id'));
            $pedido->list = json_encode($request->only('list'));
            $pedido->user_id = implode('', $request->only('user'));
            $pedido->type = 2;
            $lista = $request->only('list');
            if($pedido->save())
            {
                foreach ($lista as $produtoLista) {
                    foreach ($produtoLista as $produtoL) {
                        $produto = App\Produto::find($produtoL['id']);
                        $produto->amount-=$produtoL['qtde'];
                        $produto->save();
                    }
                }
                return response()->json(['sucesso' => 'Pedido realizado']);
            }
        }
        catch (\Exception $e)
        {
            return $e;
        }
    }
}
