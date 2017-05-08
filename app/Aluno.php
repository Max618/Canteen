<?php

namespace Canteen;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = [
        'turma',
    ];

    // UM ALUNO TEM UM RELACIONAMENTO
    public function relacionamento()
    {
        return $this->hasOne('Canteen\Relacionamento');
    }

    // UM ALUNO VEM DE UM USER
    public function user()
    {
        return $this->hasOne('Canteen\User','id');
    }

    // UM ALUNO TEM MUITOS PEDIDOS
    public function pedidos()
    {
        return $this->hasMany('Canteen\Pedido');
    }


}
