<?php

namespace Canteen;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'aluno_id', 'final_price', 'list', 'user_id', 'delivery_date', 'type'
    ];

    protected $casts = [
        //'delivery_date' => 'date',
    ];

    // UM PEDIDO VEM DE UM ALUNO, MUITOS PEDIDOS TEM UM ALUNO
    public function aluno()
    {
        return $this->belongsTo('Canteen\Aluno');
    }

    // UM PEDIDO VEM DE UM USER, MUITOS PEDIDOS TEM UM USER
    public function user()
    {
        return $this->belongsTo('Canteen\User');
    }
}
